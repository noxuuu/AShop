<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:39
 */

namespace App\Controller\admin;

use App\Entity\PaymentMethod;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Tariffs;
use App\Form\admin\tariffType;
use App\Service\logService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;


class tariffsController extends AbstractController
{
    private $logService;

    public function __construct(logService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * @Route("/admin/tariffs", name="admin_tariffs")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function tariffs(PaginatorInterface $paginator, Request $request)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for query ===
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);

        // === Get some data ===
        $tariffsRepo = $this->getDoctrine()->getRepository(Tariffs::class);
        $pmRepo = $this->getDoctrine()->getRepository(PaymentMethod::class);

        // === Create forms ===
        $tariff = new Tariffs();
        $form_add = $this->createForm(tariffType::class, $tariff);
        $form_edit = $this->createForm(tariffType::class, $tariff);

        return $this->render('admin/tariffs.html.twig', [
            'title' => 'Usługi',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Zarządzanie', '#'],
                ['Taryfy', $this->generateUrl('admin_tariffs')]
            ],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'pagination' => $paginator->paginate($tariffsRepo->findAll(), $request->query->getInt('page', 1), 30),
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

                $this->logService->logAction('add', 'Dodano nową taryfę.');
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
                $this->logService->logAction('edit', 'Edytowano taryfę [#'.$tariff->getId().'].');

            } catch (\Exception $e) {
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }

        return $this->redirectToRoute('admin_tariffs');
    }

    /**
     * @Route("/admin/tariffs/delete/{id}", name="delete_tariff", requirements={"id"="\d+"})
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteTariff(Request $request, $id)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $tariff = $this->getDoctrine()->getRepository(Tariffs::class)->find($id);

            if($tariff)
            {
                $entityManager->remove($tariff);
                $entityManager->flush();

                $data[1] = true;
                $this->logService->logAction('delete', 'Usunięto taryfę');
            }
            else
                $data[1] = false;

        } catch (\Exception $e) {
            $data[1] = false;
        }

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($data);
        else
            throw new \Exception('Not allowed usage');
    }
}