<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:37
 */

namespace App\Controller\admin;

use App\Entity\BoughtServicesLogs;
use App\Entity\Groups;
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


class statsController extends AbstractController
{
    /**
     * @Route("/admin/stats", name="admin_stats")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function stats()
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // get day
        $date = new \DateTime();
        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y")) - 43199; // sub 12 hours, we need move to start of the day, not middle
        $todayUTS = mktime (0, 0, 0, date("m"), date("d"), date("Y")) - 43199; // sub 12 hours, we need move to start of the day, not middle
        $daysCount = round(($date->getTimestamp() - $firstDayUTS)/86400); // count days before month start to now

        // === Get repo for queries ===
        $usersRepo = $this->getDoctrine()->getRepository(UsersEntity::class);
        $groupsRepo = $this->getDoctrine()->getRepository(Groups::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $userServicesRepo = $this->getDoctrine()->getRepository(UserServices::class);
        $smsRepo = $this->getDoctrine()->getRepository(PaymentsSMS::class);
        $pscRepo = $this->getDoctrine()->getRepository(PaymentsPSC::class);
        $transferRepo = $this->getDoctrine()->getRepository(PaymentsTransfer::class);
        $bslRepo = $this->getDoctrine()->getRepository(BoughtServicesLogs::class);

        // get some stats
        $stats['users'] = $usersRepo->countEm();
        $stats['groups'] = $groupsRepo->countEm();
        $stats['servers'] = $serversRepo->countEm();
        $stats['sent_sms'] = $smsRepo->countEm();
        $stats['active_services'] = $userServicesRepo->countEm();

        // set defaults
        $stats['alltime_income'] = 0;
        $stats['monthly_income'] = 0;
        $stats['last_month_income'] = 0;
        $stats['sent_sms_monthly'] = 0;
        $stats['sent_sms_last_month'] = 0;
        $stats['alltime_bought_services'] = 0;
        $stats['month_bought_services'] = 0;
        $stats['bought_services_last_month'] = 0;
        $stats['income_percent'] = 100;
        $stats['sent_sms_percent'] = 100;
        $stats['bought_services_percent'] = 100;
        $stats['target_income_percent'] = 0;
        $stats['target_sent_sms_percent'] = 0;
        $stats['target_bought_services_percent'] = 0;

        // get income
        $smsStats = $smsRepo->findAll();
        $pscStats = $pscRepo->findAll();
        $bsStats = $bslRepo->findAll();
        $transferStats = $transferRepo->findAll();

        // sms income
        foreach ($smsStats as $sms) {
            $stats['alltime_income'] += $sms->getIncome();
            if ($sms->getDate()->getTimestamp() >= $firstDayUTS) {
                $stats['sent_sms_monthly'] += 1;
                $stats['monthly_income'] += $sms->getIncome();
            }

            // if payment time < first day of this month and >= first day of previous month
            if ($sms->getDate()->getTimestamp() < $firstDayUTS && $sms->getDate()->getTimestamp() >= $firstDayUTS - 2592000) {
                $stats['sent_sms_last_month'] += 1;
                $stats['last_month_income'] += $sms->getIncome();
            }
        }

        // psc income
        foreach ($pscStats as $psc){
            $stats['alltime_income'] += $psc->getCost();
            if($psc->getDate()->getTimestamp() >= $firstDayUTS)
                $stats['monthly_income'] += $psc->getCost();

            // if payment time < first day of this month and >= first day of previous month
            if ($psc->getDate()->getTimestamp() < $firstDayUTS && $psc->getDate()->getTimestamp() >= $firstDayUTS - 2592000)
                $stats['last_month_income'] += $psc->getIncome();
        }

        // transfer income
        foreach ($transferStats as $transfer){
            $stats['alltime_income'] += $transfer->getCost();
            if($transfer->getDate()->getTimestamp() >= $firstDayUTS)
                $stats['monthly_income'] += $transfer->getCost();

            // if payment time < first day of this month and >= first day of previous month
            if ($transfer->getDate()->getTimestamp() < $firstDayUTS && $transfer->getDate()->getTimestamp() >= $firstDayUTS - 2592000)
                $stats['last_month_income'] += $transfer->getIncome();
        }

        // monthly bought services
        foreach ($bsStats as $service){
            if($service->getDate()->getTimestamp() >= $firstDayUTS)
                $stats['month_bought_services'] += 1;

            if ($service->getDate()->getTimestamp() < $firstDayUTS && $service->getDate()->getTimestamp() >= $firstDayUTS - 2592000)
                $stats['bought_services_last_month'] += 1;

            $stats['alltime_bought_services']++;
        }

        // most bought services chart data
        $boughtServicesByService = $bslRepo->findDistinctByService();
        $boughtServicesByServer = $bslRepo->findDistinctByServer();

        // monthly targets
        $stats['target_income_percent'] = round(($stats['monthly_income']/$settingsRepo->findOneBy(['name' => 'stats_target_income'])->getValue())*100.0);
        $stats['target_sent_sms_percent'] = round(($stats['sent_sms_monthly']/$settingsRepo->findOneBy(['name' => 'stats_target_send_sms'])->getValue())*100.0);
        $stats['target_bought_services_percent'] = round(($stats['month_bought_services']/$settingsRepo->findOneBy(['name' => 'stats_target_sold_services'])->getValue())*100.0);

        // Statistics against the previous month
        if($stats['last_month_income'] > 0.0)
            $stats['income_percent'] = round(($stats['monthly_income']/$stats['last_month_income'])*100.0);
        if($stats['sent_sms_last_month'] > 0)
            $stats['sent_sms_percent'] = round(($stats['sent_sms_monthly']/$stats['sent_sms_last_month'])*100.0);
        if($stats['bought_services_last_month'] > 0)
            $stats['bought_services_percent'] = round(($stats['month_bought_services']/$stats['bought_services_last_month'])*100.0);

        // ==== get income for charts ====
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

        // finally, render this shit
        return $this->render('admin/stats.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'title' => 'Statystyki',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Statystyki', $this->generateUrl('admin_stats')]
            ],
            'servers' => $serversRepo->findAll(),
            'services' => $servicesRepo->findAll(),
            'stats' => $stats,
            'days' => $daysCount,
            'chart_services' => $boughtServicesByService,
            'chart_servers' => $boughtServicesByServer
        ]);
    }
}