<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:45
 */

namespace App\Controller\admin;

use App\Entity\PaymentsSMS;
use App\Entity\PaymentsPSC;
use App\Entity\PaymentsTransfer;
use App\Entity\Servers;
use App\Entity\Services;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class paymentLogsController extends AbstractController
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

        // === Get repo for query ===
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);


        return $this->render('admin/logs/smslogs.html.twig', [
            'title' => 'Logi: Płatności SMS',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Logi', '#'],
                ['Płatności SMS', $this->generateUrl('admin_logs_sms')]
            ],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'pagination' => $paginator->paginate($logsRepo->findAll(), $request->query->getInt('page', 1), 20)
        ]);
    }
    /**
     * @Route("/admin/logs/payments/psc", name="admin_logs_psc")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminPSCPayment(PaginatorInterface $paginator, Request $request)
    {
        // === Get repo for query ===
        $logsRepo = $this->getDoctrine()->getRepository(PaymentsPSC::class);

        // === Get repo for query ===
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);


        return $this->render('admin/logs/psclogs.html.twig', [
            'title' => 'Logi: Płatności PaySafeCard',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Logi', '#'],
                ['Płatności PaySafeCard', $this->generateUrl('admin_logs_psc')]
            ],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'pagination' => $paginator->paginate($logsRepo->findAll(), $request->query->getInt('page', 1), 20)
        ]);
    }
    /**
     * @Route("/admin/logs/payments/transfer", name="admin_logs_transfer")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminTransferPayment(PaginatorInterface $paginator, Request $request)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for query ===
        $logsRepo = $this->getDoctrine()->getRepository(PaymentsTransfer::class);

        // === Get repo for query ===
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);


        return $this->render('admin/logs/transferlogs.html.twig', [
            'title' => 'Logi: Płatności Przelewem',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Logi', '#'],
                ['Płatności Przelewem', $this->generateUrl('admin_logs_transfer')]
            ],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'pagination' => $paginator->paginate($logsRepo->findAll(), $request->query->getInt('page', 1), 20)
        ]);
    }
}