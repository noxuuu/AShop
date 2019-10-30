<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:45
 */

namespace App\Controller\admin;

use App\Entity\PaymentsSMS;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class paymentSMSController extends AbstractController
{
    /**
     * @Route("/admin/logs/payments/sms", name="admin_logs_sms")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminSMSPayment(PaginatorInterface $paginator, Request $request)
    {
        // === Get repo for query ===
        $logsRepo = $this->getDoctrine()->getRepository(PaymentsSMS::class);


        return $this->render('admin/logs/smslogs.html.twig', [
            'pagination' => $paginator->paginate($logsRepo->findAll(), $request->query->getInt('page', 1), 30)
        ]);
    }
}