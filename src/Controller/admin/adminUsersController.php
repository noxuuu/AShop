<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:40
 */

namespace App\Controller\admin;

use App\Entity\Groups;
use App\Entity\UsersEntity;
use App\Form\admin\adminUsersType;
use App\Form\admin\userWalletType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class adminUsersController extends AbstractController
{
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

        // === Create Form ===
        $user = new UsersEntity();
        $defaultData = [];

        // get entity manager
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(adminUsersType::class, $user);
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
            'form_add' => $form_add->createView(),
            'form_wallet' => $form_wallet,
            'pagination' => $paginator->paginate($usersRepo->findAll(), $request->query->getInt('page', 1), 30)
        ]);
    }

    /**
     * @Route("/admin/users/{username}/wallet/edit", name="edit_wallet")
     * @Entity("username", expr="repository.find(username)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editWallet(Request $request, UsersEntity $username)
    {
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
     * @Route("/admin/users/delete/{username}", name="delete_user")
     * @param int $username
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteUser($username)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getDoctrine()->getRepository(UsersEntity::class)->find($username);

            if($user) {
                $admin = $this->getUser();
                if($username != $admin->getUsername())
                {
                    $entityManager->remove($user);
                    $entityManager->flush();
                }
                else{
                    $this->addFlash('delete_error', 'Nie możesz usunąć własnego konta!');
                    return $this->redirectToRoute('admin_users');
                }
            } else {
                $this->addFlash('delete_error', 'Nie ma takiego użytkownika!');
                return $this->redirectToRoute('admin_users');
            }

            $this->addFlash('delete_success', 'Usunięto konto użytkownika!');

        } catch (\Exception $e) {
            $this->addFlash('delete_error', 'Wystąpił niespodziewany błąd.');
        }

        return $this->redirectToRoute('admin_users');
    }
    // todo add edit user form
    // todo add search filter
    // fix modal will not show when user have special chars in name -- need to change modal identification type
    // fix form_add errors validation
}