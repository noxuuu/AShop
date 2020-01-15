<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:40
 */

namespace App\Controller\admin;

use App\Entity\Groups;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\UsersEntity;
use App\Form\admin\adminUsersType;
use App\Form\admin\userWalletType;
use App\Service\logService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class usersController extends AbstractController
{
    private $logService;

    public function __construct(logService $logService)
    {
        $this->logService = $logService; // we need to get service and log features happen in this controller :)
    }

    /**
     * @Route("/admin/users", name="admin_users")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function users(PaginatorInterface $paginator, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for query ===
        $usersRepo = $this->getDoctrine()->getRepository(UsersEntity::class);
        $groupsRepo = $this->getDoctrine()->getRepository(Groups::class);
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);

        // === Create Form ===
        $user = new UsersEntity();
        $defaultData = [];

        // get entity manager
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(adminUsersType::class, $user);
        $form_edit = $this->createForm(adminUsersType::class, $user);
        $form_wallet = $this->createForm(userWalletType::class, $defaultData);
        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {
            // encode password
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // set groupid
            $user->setGroupId($groupsRepo->find($form_add->getData()->getGroupId()));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nowego użytkownika!');

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/users.html.twig', [
            'title' => 'Użytkownicy',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Zarządzanie', '#'],
                ['Konta użytkowników', $this->generateUrl('admin_users')]
            ],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'form_add' => $form_add->createView(),
            'form_edit' => $form_edit,
            'form_wallet' => $form_wallet,
            'pagination' => $paginator->paginate($usersRepo->findAll(), $request->query->getInt('page', 1), 20)
        ]);
    }

    /**
     * @Route("/admin/users/{user}/edit", name="edit_user")
     * @Entity("user", expr="repository.find(user)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editUser(Request $request, UsersEntity $user, UserPasswordEncoderInterface $passwordEncoder)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // get repo access
        $groupsRepo = $this->getDoctrine()->getRepository(Groups::class);

        // we need to reset group id cuz form handler gives us shit..
        $user->setGroupId(1);

        // handle form
        $editForm = $this->createForm(adminUsersType::class, $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                // encode password
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                // set group id
                $user->setGroupId($groupsRepo->find($editForm->getData()->getGroupId()));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $this->addFlash('edit_success', 'Edytowano użytkownika ['.$user->getUsername().']!');
                $this->logService->logAction('edit', 'Edytowano użytkownika [#'.$user->getUsername().'].');

            } catch (\Exception $e) {
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }
        return $this->redirectToRoute('admin_users');
    }

    /**
     * @Route("/admin/users/{username}/wallet/edit", name="edit_wallet")
     * @Entity("username", expr="repository.find(username)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editWallet(Request $request, UsersEntity $username)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // get form type to handle it
        $defaultData = [];
        $editForm = $this->createForm(userWalletType::class, $defaultData);
        $editForm->handleRequest($request);

        // validate form
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // get some data
            $formData = $editForm->getData();

            // set wallet
            $username->setWallet($formData['value']);

            try {
                // get entity manager
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                // notify admin
                $this->addFlash('edit_success', 'Edytowano portfel uźytkownika!');

            } catch (\Exception $e) { // catch error and send notification if they exist
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }

        // go back to users page
        return $this->redirectToRoute('admin_users');
    }

    /**
     * @Route("/admin/users/delete/{id}", name="delete_user")
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteUser(Request $request, $id)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getDoctrine()->getRepository(UsersEntity::class)->find($id);

            if($user) {
                $admin = $this->getUser();
                if($id != $admin->getUsername())
                {
                    // save data ( we need to send it in json later)
                    $data[0] = $id;

                    // remove object
                    $entityManager->remove($user);
                    $entityManager->flush();

                    $data[1] = true;
                    $this->logService->logAction('delete', 'Usunięto użytkownika ['.$data[0].'].');
                }
                else{
                    $data[1] = false;
                }
            } else {
                $data[1] = false;
            }
        } catch (\Exception $e) {
            $data[1] = false;
        }

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($data);
        else
            throw new \Exception('Not allowed usage');
    }

    // todo add edit user form
    // todo add search filter
    // fix form_add errors validation
}