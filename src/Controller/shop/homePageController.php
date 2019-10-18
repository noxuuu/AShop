<?php
namespace App\Controller\shop;

use App\Entity\BoughtServicesLogs;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\UsersEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $usersRepo = $this->getDoctrine()->getRepository(UsersEntity::class);
        $boughtServicesRepo = $this->getDoctrine()->getRepository(BoughtServicesLogs::class);

        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();
        $users = $usersRepo->findAll();
        $boughtServices = $boughtServicesRepo->findAll();

        $breadcrumbs = [];

        return $this->render('frontend/homepage/index.html.twig', [
            'services' => $services,
            'servers' => $servers,
            'users' => $users,
            'boughtServices' => $boughtServices,
            'title' => 'Strona główna - Sklep Automatyczny!',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /** DELETE CONTROLLERS UNDER THIS COMMENT **/

    /**
     * Get common of AShop
     *
     * @Route("/faq", name="faq")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function faq()
    {
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();
        $breadcrumbs = [];

        return $this->render('frontend/pages/faq/index.html.twig', [
            'services' => $services,
            'servers' => $servers,
            'title' => 'Często zadawane pytania',
            'breadcrumbs' => $breadcrumbs
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
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();
        $breadcrumbs = [];

        return $this->render('frontend/pages/vouchers/index.html.twig', [
            'services' => $services,
            'servers' => $servers,
            'title' => 'Wykorzystaj voucher',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Get common of AShop
     *
     * @Route("/default-page", name="default-page")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function defaulpage()
    {
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();
        $breadcrumbs = [];

        return $this->render('frontend/pages/default-page/index.html.twig', [
            'services' => $services,
            'servers' => $servers,
            'title' => 'Wykorzystaj voucher',
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}