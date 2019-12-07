<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 05:59
 */

namespace App\Controller\admin;

use App\Entity\AdminLogs;
use App\Entity\BoughtServicesLogs;
use App\Entity\PaymentsPSC;
use App\Entity\PaymentsSMS;
use App\Entity\PaymentsTransfer;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\UsersEntity;
use App\Entity\UserServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for admin common.
 *
 * Class dashboardController
 * @package App\Controller
 */
class dashboardController extends AbstractController
{
    /**
     * Get admin dashboard
     *
     * @Route("/admin/", name="admin")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function dashboard()
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // get repo's
        $usersRepo = $this->getDoctrine()->getRepository(UsersEntity::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $userServicesRepo = $this->getDoctrine()->getRepository(UserServices::class);
        $smsRepo = $this->getDoctrine()->getRepository(PaymentsSMS::class);
        $pscRepo = $this->getDoctrine()->getRepository(PaymentsPSC::class);
        $transferRepo = $this->getDoctrine()->getRepository(PaymentsTransfer::class);
        $bslRepo = $this->getDoctrine()->getRepository(BoughtServicesLogs::class);
        $adminsRepo = $this->getDoctrine()->getRepository(AdminLogs::class);

        // get some stats
        $stats['users'] = $usersRepo->countEm();
        $stats['servers'] = $serversRepo->countEm();
        $stats['sent_sms'] = $smsRepo->countEm();
        $stats['bought_services'] = $bslRepo->countEm();
        $stats['active_services'] = $userServicesRepo->countEm();

        // get first day of month
        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $firstDay = date("d-m-Y", $firstDayUTS);

        // set defaults
        $stats['alltime_income'] = 0;
        $stats['monthly_income'] = 0;
        $stats['alltime_bought_services'] = 0;
        $stats['month_bought_services'] = 0;
        $stats['users_count'] = $usersRepo->findAll();

        // get income
        $smsStats = $smsRepo->findAll();
        $pscStats = $pscRepo->findAll();
        $bsStats = $bslRepo->findAll();
        $transferStats = $transferRepo->findAll();

        // sms income
        foreach ($smsStats as $sms){
            $stats['alltime_income'] += $sms->getIncome();
            if($sms->getDate() >= $firstDay)
                $stats['monthly_income'] += $sms->getIncome();
        }

        // psc income
        foreach ($pscStats as $psc){
            $stats['alltime_income'] += $psc->getCost();
            if($psc->getDate() >= $firstDay)
                $stats['monthly_income'] += $psc->getCost();
        }

        // transfer income
        foreach ($transferStats as $transfer){
            $stats['alltime_income'] += $transfer->getCost();
            if($transfer->getDate() >= $firstDay)
                $stats['monthly_income'] += $transfer->getCost();
        }

        // monthly bought services
        foreach ($bsStats as $service){
            if($service->getDate() >= $firstDay)
                $stats['month_bought_services'] += 1;
            $stats['alltime_bought_services']++;
        }

        // most bought chart data
        $boughtServices = $bslRepo->findAllDistinct();

        // render page
        return $this->render('admin/dashboard.html.twig', [
            'title' => 'Panel Kontrolny',
            'breadcrumbs' => [['Panel Administracyjny', $this->generateUrl('admin')]],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'stats' => $stats,
            'users' => $usersRepo->findLastRegistrations(1),
            'last_bought' => $bslRepo->findLastPucharses(3),
            'last_activity' => $adminsRepo->getLastActivity(7),
            'chart_services' => $boughtServices
        ]);
    }
}