<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:43
 */

namespace App\Controller\admin;

use App\Entity\AdminLogs;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Settings;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class adminLogsController extends AbstractController
{
    /**
     * @Route("/admin/logs/admin", name="admin_logs")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminLogs(PaginatorInterface $paginator, Request $request)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for query ===
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);

        // === Get repo for query ===
        $logsRepo = $this->getDoctrine()->getRepository(AdminLogs::class);


        return $this->render('admin/logs/adminlogs.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'title' => 'Logi Administracyjne',
            'breadcrumbs' => [['Panel Administracyjny', $this->generateUrl('admin')], ['Sklep', '#'], ['Logi Administracyjne', $this->generateUrl('admin_logs')]],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'pagination' => $paginator->paginate($logsRepo->findAll(), $request->query->getInt('page', 1), 20)
        ]);
    }
}