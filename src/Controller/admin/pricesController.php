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
        //$form_add = $this->createForm(pricesType::class, $price);
        //$form_edit = $this->createForm(pricesType::class, $price);

        return $this->render('admin/prices.html.twig', [
            'pagination' => $paginator->paginate($pricesRepo->findAll(), $request->query->getInt('page', 1), 30),
            'tariffs' => $tariffsRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'services' => $servicesRepo->findAll(),
            //'form_add' => $form_add,
            //'form_edit' => $form_edit
        ]);
    }

    /*/**
     * @Route("/admin/prices/add/{pm}", name="add_tariff")
     * @Entity("pm", expr="repository.find(pm)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception

    public function addPrice(Request $request, PaymentMethod $pm)
    {
        // === create default data ===
        $tariff = new Tariffs();
        $addForm = $this->createForm(tariffType::class, $tariff);
        $addForm->handleRequest($request);

        // === validate form & save data ===
        if ($addForm->isSubmitted() && $addForm->isValid()) {
            try {
                $tariff->setPaymentMethodId($pm);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($tariff);
                $entityManager->flush();

                $this->addFlash('add_success', 'Dodano nową taryfę!');

            } catch (\Exception $e) {
                $this->addFlash('add_error', 'Wystąpił niespodziewany błąd.');
            }
        }

        return $this->redirectToRoute('admin_prices');
    }*/

    /**
     * @Route("/admin/prices/{price}/edit", name="edit_price")
     * @Entity("price", expr="repository.find(price)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editPrice(Request $request, Prices $price)
    {
        $editForm = $this->createForm(pricesType::class, $price);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $this->addFlash('edit_success', 'Edytowano cenę!');

            } catch (\Exception $e) {
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }

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