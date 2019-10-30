<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:45
 */

namespace App\Controller\admin;

use App\Entity\PaymentsPSC;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class paymentPSCController extends AbstractController
{
    /**
     * @Route("/admin/logs/payments/psc", name="admin_logs_psc")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminSMSPayment(PaginatorInterface $paginator, Request $request)
    {
        // === Get repo for query ===
        $logsRepo = $this->getDoctrine()->getRepository(PaymentsPSC::class);


        return $this->render('admin/logs/psclogs.html.twig', [
            'pagination' => $paginator->paginate($logsRepo->findAll(), $request->query->getInt('page', 1), 30)
        ]);
    }
}