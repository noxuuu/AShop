<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:42
 */

namespace App\Controller\admin;

use App\Entity\BoughtServicesLogs;
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


        return $this->render('admin/logs/adminbsl.html.twig', [
            'pagination' => $paginator->paginate($bsRepo->findAll(), $request->query->getInt('page', 1), 30)
        ]);
    }
}