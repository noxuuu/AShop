<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:42
 */

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class boughtServicesLogsController extends AbstractController
{
    /**
     * @Route("/admin/logs/bought_services", name="admin_bslogs")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function boughtServicesLogs()
    {
        return $this->render('admin/adminbsl.html.twig');
    }
}