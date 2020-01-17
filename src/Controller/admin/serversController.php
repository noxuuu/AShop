<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:32
 */

namespace App\Controller\admin;

use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Settings;
use App\Form\admin\serversType;
use App\Service\logService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class serversController extends AbstractController
{
    private $logService;

    public function __construct(logService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * @Route("/admin/servers", name="admin_servers")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminServers(PaginatorInterface $paginator, Request $request)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for query ===
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);

        // === Create Form ===
        $server = new Servers();
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(serversType::class, $server);
        $form_edit = $this->createForm(serversType::class, $server);
        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {

            $server->setConnected(false);

            $entityManager->persist($server);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nowy serwer!');
            $this->logService->logAction('add', 'Dodano nowy serwer [#'.$server->getName().', #'.$server->getIpAddress().':'.$server->getPort().']');

            return $this->redirectToRoute('admin_servers');
        }

        return $this->render('admin/servers.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'title' => 'Serwery',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Zarządzanie', '#'],
                ['Serwery', $this->generateUrl('admin_servers')]
            ],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'form_add' => $form_add->createView(),
            'form_edit' => $form_edit,
            'pagination' => $paginator->paginate($serversRepo->findAll(),$request->query->getInt('page', 1),30)
        ]);
    }

    /**
     * @Route("/admin/servers/{server}/edit", name="edit_server")
     * @Entity("server", expr="repository.find(server)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editServer(Request $request, Servers $server)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $serverName = $server->getName();

        $editForm = $this->createForm(serversType::class, $server);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $this->addFlash('edit_success', 'Edytowano '.$serverName.'!');
                $this->logService->logAction('edit', 'Edytowano serwer [#'.$serverName.']');

            } catch (\Exception $e) {
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }

        return $this->redirectToRoute('admin_servers');
    }

    /**
     * @Route("/admin/servers/delete/{id}", name="delete_server")
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteServer(Request $request, $id)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $server = $this->getDoctrine()->getRepository(Servers::class)->find($id);

            if($server)
            {
                $data[0] = $server->getName();
                $entityManager->remove($server);
                $entityManager->flush();

                $data[1] = true;
                $this->logService->logAction('delete', 'Usunięto serwer [#'.$data[0].']');
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