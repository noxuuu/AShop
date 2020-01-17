<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:30
 */

namespace App\Controller\admin;

use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Settings;
use App\Form\admin\servicesType;
use App\Service\logService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class servicesController extends AbstractController
{
    private $logService;

    public function __construct(logService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * @Route("/admin/services", name="admin_services")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminServers(PaginatorInterface $paginator, Request $request)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for query ===
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);

        // === Create Form ===
        $service = new Services();
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(servicesType::class, $service);
        $form_edit = $this->createForm(servicesType::class, $service);
        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {

            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową usługę!');
            $this->logService->logAction('add', 'Dodano nową usługę [#'.$service->getName().']');

            return $this->redirectToRoute('admin_services');
        }

        return $this->render('admin/services.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'title' => 'Usługi',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Zarządzanie', '#'],
                ['Usługi', $this->generateUrl('admin_services')]
            ],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'form_add' => $form_add->createView(),
            'form_edit' => $form_edit,
            'pagination' => $paginator->paginate($servicesRepo->findAll(),$request->query->getInt('page', 1),20)
        ]);
    }

    /**
     * @Route("/admin/services/{service}/edit", name="edit_service")
     * @Entity("service", expr="repository.find(service)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editService(Request $request, Services $service)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $serviceName = $service->getName();

        $editForm = $this->createForm(servicesType::class, $service);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $this->addFlash('edit_success', 'Edytowano '.$serviceName.'!');
                $this->logService->logAction('edit', 'Edytowano usługę [#'.$serviceName.']');

            } catch (\Exception $e) {
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }

        return $this->redirectToRoute('admin_services');
    }

    /**
     * @Route("/admin/services/delete/{id}", name="delete_service")
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteService(Request $request, $id)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $service = $this->getDoctrine()->getRepository(Services::class)->find($id);

            if($service)
            {
                $data[0] = $service->getName();
                $entityManager->remove($service);
                $entityManager->flush();

                $data[1] = true;
                $this->logService->logAction('delete', 'Usunięto usługę [#'.$data[0].']');
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