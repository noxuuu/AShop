<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:45
 */

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class paymentLogsController extends AbstractController
{
    /**
     * @Route("/admin/logs/payments/", name="admin_logs_payment")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminLogsPayment()
    {
        return $this->render('admin/paymentlogs.html.twig');
    }
}