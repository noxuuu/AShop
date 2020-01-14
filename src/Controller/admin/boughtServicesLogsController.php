<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:42
 */

namespace App\Controller\admin;

use App\Entity\BoughtServicesLogs;
use App\Entity\Servers;
use App\Entity\Services;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class boughtServicesLogsController extends AbstractController
{
    /**
     * @Route("/admin/logs/bought_services", name="admin_bslogs")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function boughtServicesLogs(PaginatorInterface $paginator, Request $request)
    {
        // === Get repo for query ===
        $bsRepo = $this->getDoctrine()->getRepository(BoughtServicesLogs::class);

        // === Get repo for query ===
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);


        return $this->render('admin/logs/adminbsl.html.twig', [
            'title' => 'Logi: Kupione Usługi',
            'breadcrumbs' => [['Panel Administracyjny', $this->generateUrl('admin')], ['Sklep', '#'], ['Logi Kupionych Usług', $this->generateUrl('admin_bslogs')]],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'pagination' => $paginator->paginate($bsRepo->findAll(), $request->query->getInt('page', 1), 30)
        ]);
    }
}