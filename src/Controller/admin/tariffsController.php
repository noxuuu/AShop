<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:39
 */

namespace App\Controller\admin;

use App\Entity\PaymentMethod;
use App\Entity\Tariffs;
use App\Form\admin\tariffType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;


class tariffsController extends AbstractController
{
    /**
     * @Route("/admin/tariffs", name="admin_tariffs")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function tariffs(PaginatorInterface $paginator, Request $request)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get some data ===
        $tariffsRepo = $this->getDoctrine()->getRepository(Tariffs::class);
        $pmRepo = $this->getDoctrine()->getRepository(PaymentMethod::class);

        // === Create forms ===
        $tariff = new Tariffs();
        $form_add = $this->createForm(tariffType::class, $tariff);
        $form_edit = $this->createForm(tariffType::class, $tariff);

        return $this->render('admin/tariffs.html.twig', [
            'pagination' => $paginator->paginate($tariffsRepo->findAll(),$request->query->getInt('page', 1),30),
            'payment_methods' => $pmRepo->findAll(),
            'form_add' => $form_add,
            'form_edit' => $form_edit
        ]);
    }

    /**
     * @Route("/admin/tariffs/add/{pm}", name="add_tariff")
     * @Entity("pm", expr="repository.find(pm)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addTariff(Request $request, PaymentMethod $pm)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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

        return $this->redirectToRoute('admin_tariffs');
    }

    /**
     * @Route("/admin/tariffs/{tariff}/edit", name="edit_tariff")
     * @Entity("tariff", expr="repository.find(tariff)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editTariff(Request $request, Tariffs $tariff)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $editForm = $this->createForm(tariffType::class, $tariff);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $this->addFlash('edit_success', 'Edytowano taryfę!');

            } catch (\Exception $e) {
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }

        return $this->redirectToRoute('admin_tariffs');
    }

    /**
     * @Route("/admin/tariffs/delete/{id}", name="delete_tariff", requirements={"id"="\d+"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteTariff($id)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $tariff = $this->getDoctrine()->getRepository(Tariffs::class)->find($id);

            $entityManager->remove($tariff);
            $entityManager->flush();

            $this->addFlash('delete_success', 'Usunięto taryfę!');

        } catch (\Exception $e) {
            $this->addFlash('delete_error', 'Wystąpił niespodziewany błąd.');
        }

        return $this->redirectToRoute('admin_tariffs');
    }
}