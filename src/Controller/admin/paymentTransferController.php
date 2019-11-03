<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:45
 */

namespace App\Controller\admin;

use App\Entity\PaymentsTransfer;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class paymentTransferController extends AbstractController
{
    /**
     * @Route("/admin/logs/payments/transfer", name="admin_logs_transfer")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminSMSPayment(PaginatorInterface $paginator, Request $request)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for query ===
        $logsRepo = $this->getDoctrine()->getRepository(PaymentsTransfer::class);


        return $this->render('admin/logs/transferlogs.html.twig', [
            'pagination' => $paginator->paginate($logsRepo->findAll(), $request->query->getInt('page', 1), 30)
        ]);
    }
}