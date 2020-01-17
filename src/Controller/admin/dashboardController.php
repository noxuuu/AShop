<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 05:59
 */

namespace App\Controller\admin;

use App\Entity\AdminLoginLogs;
use App\Entity\AdminLogs;
use App\Entity\BoughtServicesLogs;
use App\Entity\PaymentsPSC;
use App\Entity\PaymentsSMS;
use App\Entity\PaymentsTransfer;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Settings;
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
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $userServicesRepo = $this->getDoctrine()->getRepository(UserServices::class);
        $smsRepo = $this->getDoctrine()->getRepository(PaymentsSMS::class);
        $pscRepo = $this->getDoctrine()->getRepository(PaymentsPSC::class);
        $transferRepo = $this->getDoctrine()->getRepository(PaymentsTransfer::class);
        $bslRepo = $this->getDoctrine()->getRepository(BoughtServicesLogs::class);
        $adminsRepo = $this->getDoctrine()->getRepository(AdminLogs::class);
        $adminLoginLogsRepo = $this->getDoctrine()->getRepository(AdminLoginLogs::class);

        // get some stats
        $stats['servers'] = $serversRepo->countEm();
        $stats['sent_sms'] = $smsRepo->countEm();
        $stats['active_services'] = $userServicesRepo->countEm();

        // get first day of month
        $date = new \DateTime();
        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y")) - 43199; // sub 12 hours, we need move to start of the day, not middle
        $todayUTS = mktime (0, 0, 0, date("m"), date("d"), date("Y")) - 43199; // sub 12 hours, we need move to start of the day, not middle
        $daysCount = round(($date->getTimestamp() - $firstDayUTS)/86400); // count days before month start to now

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
            if($sms->getDate()->getTimestamp() >= $firstDayUTS)
                $stats['monthly_income'] += $sms->getIncome();
        }

        // psc income
        foreach ($pscStats as $psc){
            $stats['alltime_income'] += $psc->getCost();
            if($psc->getDate()->getTimestamp() >= $firstDayUTS)
                $stats['monthly_income'] += $psc->getCost();
        }

        // transfer income
        foreach ($transferStats as $transfer){
            $stats['alltime_income'] += $transfer->getCost();
            if($transfer->getDate()->getTimestamp() >= $firstDayUTS)
                $stats['monthly_income'] += $transfer->getCost();
        }

        // monthly bought services
        foreach ($bsStats as $service){
            if($service->getDate()->getTimestamp() >= $firstDayUTS)
                $stats['month_bought_services'] += 1;
            $stats['alltime_bought_services']++;
        }

        // most bought chart data
        $boughtServices = $bslRepo->findDistinctByService();

        // ==== get income for charts ====
        $cost = array();
        $timestamp_scope = $date->getTimestamp() - $todayUTS;// get today timestamp scope

        for($i = 1; $i <= $daysCount; $i++) {
            // get day timestamp
            $day_timestamp = $date->getTimestamp() - (($daysCount - $i)*86400) - $timestamp_scope;

            // set defaults
            $stats['salesMonthly'][$i] = 0;

            // sms income
            foreach ($smsStats as $sms){
                if($sms->getDate()->getTimestamp() >= $day_timestamp && $sms->getDate()->getTimestamp() < $day_timestamp + 86400)
                    $stats['salesMonthly'][$i] += $sms->getIncome();
            }

            // psc income
            foreach ($pscStats as $psc){
                if($psc->getDate()->getTimestamp() >= $day_timestamp && $psc->getDate()->getTimestamp() < $day_timestamp + 86400)
                    $stats['salesMonthly'][$i] += $psc->getCost();
            }

            // transfer income
            foreach ($transferStats as $transfer){
                if($transfer->getDate()->getTimestamp() >= $day_timestamp && $transfer->getDate()->getTimestamp() < $day_timestamp + 86400)
                    $stats['salesMonthly'][$i] += $transfer->getCost();
            }
        }

        // render page
        return $this->render('admin/dashboard.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'title' => 'Panel Kontrolny',
            'breadcrumbs' => [['Panel Administracyjny', $this->generateUrl('admin')]],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'stats' => $stats,
            'users' => $usersRepo->findLastRegistrations(1),
            'last_bought' => $bslRepo->findLastPucharses(3),
            'last_acp_logins' => $adminLoginLogsRepo->getLastActivity(3),
            'last_activity' => $adminsRepo->getLastActivity(7),
            'days' => $daysCount,
            'chart_services' => $boughtServices
        ]);
    }
}