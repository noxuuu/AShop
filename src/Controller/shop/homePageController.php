<?php

namespace App\Controller\shop;

use App\Entity\BoughtServicesLogs;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Settings;
use App\Entity\UsersEntity;
use App\Form\contactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Controller for common.
 *
 * Class HomePageController
 * @package App\Controller
 */
class homePageController extends AbstractController
{
    /**
     * Get common of AShop
     *
     * @Route("/", name="homePage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function homePage()
    {
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);
        $usersRepo = $this->getDoctrine()->getRepository(UsersEntity::class);
        $boughtServicesRepo = $this->getDoctrine()->getRepository(BoughtServicesLogs::class);

        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();
        $users = $usersRepo->findAll();
        $boughtServices = $boughtServicesRepo->findAll();

        $breadcrumbs = [];

        return $this->render('frontend/homepage/index.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'services' => $services,
            'servers' => $servers,
            'users' => $users,
            'boughtServices' => $boughtServices,
            'title' => 'Strona główna - Sklep Automatyczny!',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Get faq
     *
     * @Route("/faq", name="faq")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function faq()
    {
        // todo make faq editable in ACP->Settings

        // get repo's
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);

        // get data
        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();

        //
        $breadcrumbs = [];

        return $this->render('frontend/pages/faq/index.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'services' => $services,
            'servers' => $servers,
            'title' => 'Często zadawane pytania',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Get terms
     *
     * @Route("/terms", name="terms")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function terms()
    {
        // todo make terms editable in ACP->settings

        // get repo's
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);

        // get data
        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();

        //
        $breadcrumbs = [];

        return $this->render('frontend/pages/terms/index.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'services' => $services,
            'servers' => $servers,
            'title' => 'Regulamin',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Get contact
     *
     * @Route("/contact", name="contact")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        // todo make contact entity - simply add new admins in ACP->settings

        // get repo's
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $usersRepo = $this->getDoctrine()->getRepository(UsersEntity::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);

        // get data
        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();

        // get users for contact widgets
        $users = $usersRepo->findUsersByGroupId($settingsRepo->findOneBy(['name' => 'contact_group'])->getValue());

        // create and handle form
        $form_contact = $this->createForm(contactType::class, []);
        $form_contact->handleRequest($request);

        if($form_contact->isSubmitted() && $form_contact->isValid()){
            // get some data
            $formData = $form_contact->getData();

            // prepare message
            $message = (new \Swift_Message('Wiadomość kontaktowa'))
                ->setFrom($formData['email'])
                ->setTo($settingsRepo->findOneBy(['name' => 'shop_email'])->getValue())
                ->setBody(
                    $this->renderView('frontend/email/contact.html.twig',[
                            'message' => $formData['message'],
                            'sender' => $formData['email']
                        ]
                    )
                );

            if($mailer->send($message))
                $this->addFlash('add_success', 'Twoja wiadomość została wysłana!');
            else
                $this->addFlash('add_error', 'Twoja wiadomość nie została wysłana!');

            return $this->redirectToRoute('contact');
        }

        return $this->render('frontend/pages/contact/index.html.twig', [
            'title' => 'Kontakt',
            'breadcrumbs' => [],
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'services' => $services,
            'servers' => $servers,
            'users' => $users,
            'form_contact' => $form_contact->createView()
        ]);
    }

    /**
     * Get common of AShop
     *
     * @Route("/voucher", name="voucher")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function voucher()
    {

        throw $this->createNotFoundException('Page is currently offline.');

        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);
        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();
        $breadcrumbs = [];

        return $this->render('frontend/pages/vouchers/index.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'services' => $services,
            'servers' => $servers,
            'title' => 'Wykorzystaj voucher',
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}