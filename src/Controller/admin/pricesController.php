<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:37
 */

namespace App\Controller\admin;

use App\Entity\Prices;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Tariffs;
use App\Form\admin\pricesType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;


class pricesController extends AbstractController
{
    /**
     * @Route("/admin/prices", name="admin_prices")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function prices(PaginatorInterface $paginator, Request $request)
    {
        // === Get some data ===
        $pricesRepo = $this->getDoctrine()->getRepository(Prices::class);
        $tariffsRepo = $this->getDoctrine()->getRepository(Tariffs::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);

        // === Create forms ===
        $price = new Prices();
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(pricesType::class, $price);
        $form_edit = $this->createForm(pricesType::class, $price);

        $form_add->handleRequest($request);


        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {

            // === Save servers in other form :) ===
            $servers = "";
            $formData = $form_add->getData();

            foreach ($formData->getServerId() as $server)
                $servers = ''.$servers.$server.'-';

            // sub last char, cuz there is useless "-"
            $servers = substr($servers,0,strlen($servers)-1);

            // === Flush to DataBase! ===
            try {
                // let's find a objects
                $price->setServerId($servers);
                $price->setServiceId($servicesRepo->find($formData->getServiceId()));
                $price->setTariffId($tariffsRepo->find($formData->getTariffId()));

                // save progress!
                $entityManager->persist($price);
                $entityManager->flush();

                $this->addFlash('add_success', 'Dodano nową cenę!');
            } catch (Exception $e) {
                $this->addFlash('add_error', 'Wystąpił niespodziewany błąd.');
            }
            return $this->redirectToRoute('admin_prices');
        }


        return $this->render('admin/prices.html.twig', [
            'pagination' => $paginator->paginate($pricesRepo->findAll(), $request->query->getInt('page', 1), 30),
            'tariffs' => $tariffsRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'services' => $servicesRepo->findAll(),
            'form_add' => $form_add->createView(),
            'form_edit' => $form_edit
        ]);
    }

    /**
     * @Route("/admin/prices/{price}/edit", name="edit_price")
     * @Entity("price", expr="repository.find(price)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editPrice(Request $request, Prices $price)
    {
        // get repo's
        $tariffsRepo = $this->getDoctrine()->getRepository(Tariffs::class);
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);

        // reset choice type list for edit form 'handller'
        $price->setServerId(['-', 0]);

        // get form type to handle it
        $editForm = $this->createForm(pricesType::class, $price);
        $editForm->handleRequest($request);

        // validate form
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // === Save servers in other form :) ===
            $servers = "";
            $formData = $editForm->getData();

            foreach ($formData->getServerId() as $server)
                $servers = ''.$servers.$server.'-';

            // sub last char, cuz there is useless "-"
            $servers = substr($servers,0,strlen($servers)-1);

            // let's find a objects
            $price->setServerId($servers);
            $price->setServiceId($servicesRepo->find($formData->getServiceId()));
            $price->setTariffId($tariffsRepo->find($formData->getTariffId()));

            try {
                // get entity manager
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                // notify admin
                $this->addFlash('edit_success', 'Edytowano cenę!');

            } catch (\Exception $e) { // catch error and send notification if they exist
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }

        // go back to prices page
        return $this->redirectToRoute('admin_prices');
    }

    /**
     * @Route("/admin/prices/delete/{id}", name="delete_price", requirements={"id"="\d+"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deletePrice($id)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $price = $this->getDoctrine()->getRepository(Prices::class)->find($id);

            $entityManager->remove($price);
            $entityManager->flush();

            $this->addFlash('delete_success', 'Usunięto cenę!');

        } catch (\Exception $e) {
            $this->addFlash('delete_error', 'Wystąpił niespodziewany błąd.');
        }

        return $this->redirectToRoute('admin_prices');
    }
}