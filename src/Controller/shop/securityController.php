<?php
namespace App\Controller\shop;

use App\Entity\Groups;
use App\Entity\Settings;
use App\Entity\UsersEntity;
use App\Form\UsersType;
use App\Service\logService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\shop\securityService;
/**
 * Controller used to authenticate users, register new users and recovery password.
 *
 * Class SecurityController
 * @package App\Controller\shop
 */

class securityController extends AbstractController
{
    /**
     * Function to login users via login/email and password.
     *
     * @Route("/login", name="login")
     * @return \Symfony\Component\HttpFoundation\Response
     * @var AuthenticationUtils $authenticationUtils
     * @var securityService $securityService
     * @throws \Exception
     */

    public function login(AuthenticationUtils $authenticationUtils, SecurityService $securityService)
    {
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);
        $login = $securityService->login($authenticationUtils);

        return $this->render('common/security/login.html.twig', array(
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'last_username' => $login['lastUsername'],
            'error' => $login['error'],
        ));
    }

    /**
     * Function to logout
     *
     * @Route("/logout", name="logout")
     */
    public function logout() {}

    /**
     * Function to register new users with login/email and password
     *
     * @Route("/register", name="register")
     * @return \Symfony\Component\HttpFoundation\Response
     * @var Request $request
     * @var UserPasswordEncoderInterface $passwordEncoder
     * @throws \Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);

        $user = new UsersEntity();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // set user group as default
            $user->setGroupId($this->getDoctrine()->getRepository(Groups::class)->findOneBy(['id' => 2]));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render('common/security/register.html.twig', [
                'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
                'form' => $form->createView()
            ]
        );
    }



}