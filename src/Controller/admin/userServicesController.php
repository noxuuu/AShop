<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:35
 */

namespace App\Controller\admin;

use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\UserServices;
use App\Form\admin\usersServicesAddType;
use App\Form\admin\usersServicesEditType;
use App\Service\logService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class userServicesController extends AbstractController
{
    private $logService;

    public function __construct(logService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * @Route("/admin/users_services", name="admin_usersServices")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function userServices(PaginatorInterface $paginator, Request $request)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for query ===
        $usRepo = $this->getDoctrine()->getRepository(UserServices::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);

        // === Load data ===
        $serverSelection = $request->query->getInt('svr', 0); // filter by server
        $rows = $serverSelection > 0 ? $usRepo->findBy(['server' => $serverSelection], ['id' => 'DESC']) : $usRepo->findBy(array(), ['id' => 'DESC']); // load all rows when server == 0 (all servers)

        // === Create Forms ===
        $defaultData = [];

        $form_add = $this->createForm(usersServicesAddType::class, $defaultData);
        $form_edit = $this->createForm(usersServicesEditType::class, $defaultData);
        $form_add->handleRequest($request);

        if ($form_add->isSubmitted() && $form_add->isValid()) {
            // get entity manager
            $entityManager = $this->getDoctrine()->getManager();

            // get some data
            $currentDate = new \DateTime();
            $formData = $form_add->getData();

            // === Loop each server ===
            foreach ($formData['server'] as $server) {
                if ($foundService = $usRepo->findOneBy(['service' => $formData['service'], 'server' => $server, 'authData' => $formData['authData']])) { // user alerady have active service, add value
                    // just add some days
                    $newFoundDate = new \DateTime();
                    $newFoundDate->setTimestamp($foundService->getExpires()->getTimestamp() + ($formData['value'] * 86400));
                    $foundService->setExpires($newFoundDate);

                    // flush data
                    $entityManager->flush();

                    // notify admin
                    $this->addFlash('edit_success', 'Przedłużono poprawnie!');
                    return $this->redirectToRoute('admin_usersServices');

                } else { // create new user service
                    $newDate = new \DateTime();
                    $userService = new UserServices();
                    $userService->setServerId($serversRepo->findOneBy(['id' => $server]));
                    $userService->setServiceId($servicesRepo->findOneBy(['id' => $formData['service']]));
                    $userService->setAuthData($formData['authData']);
                    $userService->setValue($formData['value']);
                    $userService->setBoughtDate($currentDate);
                    $userService->setExpires($newDate->setTimestamp($currentDate->getTimestamp() + ($formData['value'] * 86400)));

                    $entityManager->persist($userService);
                    $entityManager->flush();

                    $this->addFlash('add_success', 'Dodano usługę!');
                    $this->logService->logAction('add', 'Dodano usługę graczowi [#'.$formData['authData'].'] [#'.$servicesRepo->findOneBy(['id' => $formData['service']])->getName().'] [#'.$serversRepo->findOneBy(['id' => $server])->getName().']');
                    return $this->redirectToRoute('admin_usersServices');
                }
            }
        }

        return $this->render('admin/usersservices.html.twig', [
            'title' => 'Usługi graczy',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Zarządzanie', '#'],
                ['Usługi graczy', $this->generateUrl('admin_usersServices')]
            ],
            'selected_server' => $serverSelection,
            'pagination' => $paginator->paginate($rows, $request->query->getInt('page', 1), 20),
            'servers' => $serversRepo->findAll(),
            'services' => $servicesRepo->findAll(),
            'form_add' => $form_add->createView(),
            'form_edit' => $form_edit,
            'search_results' => false
        ]);
    }

    /**
     * @Route("/admin/users_services/{service}/edit", name="edit_userservice")
     * @Entity("service", expr="repository.find(service)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editService(Request $request, UserServices $service)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // get form type to handle it
        $defaultData = [];
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $editForm = $this->createForm(usersServicesEditType::class, $defaultData);
        $editForm->handleRequest($request);

        // validate form
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // get some data
            $formData = $editForm->getData();

            // parse data
            $setDate = \DateTime::createFromFormat('d/m/Y H:i:s', $formData['value']);

            // set new data
            $service->setServiceId($servicesRepo->find($formData['service']));
            $service->setAuthData($formData['authData']);
            $service->setExpires($setDate);

            try {
                // get entity manager
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                // notify admin
                $this->addFlash('edit_success', 'Edytowano usłgę!');
                $this->logService->logAction('edit', 'Edytowano usługę gracza [#'.$service->getAuthData().']');

            } catch (\Exception $e) { // catch error and send notification if they exist
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }

        // go back to prices page
        return $this->redirectToRoute('admin_usersServices');
    }

    /**
     * @Route("/admin/users_services/delete/{id}", name="delete_userservice", requirements={"id"="\d+"})
     * @return JsonResponse
     * @throws \Exception
     */
    public function deletePrice(Request $request, $id)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $service = $this->getDoctrine()->getRepository(UserServices::class)->find($id);

            if($service)
            {
                $data[0] = $service->getAuthData();
                $entityManager->remove($service);
                $entityManager->flush();

                $data[1] = true;
                $this->logService->logAction('delete', 'Usunięto usługę gracza [#'.$data[0].']');
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