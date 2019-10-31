<?php

namespace App\Controller\shop;

use App\Entity\BoughtServicesLogs;
use App\Entity\Prices;
use App\Entity\Servers;
use App\Entity\Services;
use App\Service\steamAuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;


/**
 * Controller for service selection.
 *
 * Class HomePageController
 * @package App\Controller
 */
class serviceInfoController extends AbstractController
{
    private $steamAuth;

    public function __construct(steamAuthService $steamAuthService)
    {
        $this->steamAuth = $steamAuthService;
    }

    /**
     * Select service
     *
     * @Route("/info/{service}", name="service_info")
     * @Entity("service", expr="repository.findByName(service)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function serviceSelect(Services $service)
    {
        // Get Bought services logs repository
        $bsRepo = $this->getDoctrine()->getRepository(BoughtServicesLogs::class);
        $pricesRepo = $this->getDoctrine()->getRepository(Prices::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);

        // get best price for this service
        $bestPrice = $pricesRepo->getBestPriceForService($service->getId());

        // get bought services count
        $bought = $bsRepo->countEmByService($service->GetId());

        // get last buyer name
        $lastBuyerName = "Brak"; // Set default value
        if ($bought) {
            $lastBuyer = $bsRepo->getLastRecordByService($service->GetId());
            $request = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=52A66B13219F645834149F1A1180770A&steamids=' . $this->steamAuth->toCommunityID($lastBuyer[0]['authData']) . '');
            $result = json_decode($request);

            foreach ($result->response->players as $player)
                $lastBuyerName = $player->personaname;
        }

        // get service's avaible servers
        $avaibleServers = array();
        $avaibleServersString = $pricesRepo->GetAvaibleServersForService($service->GetId());

        // Get Data for navigation
        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();

        // loop query results
        for ($i = 0; $i < count($avaibleServersString); $i++) {
            $output = explode("-", $avaibleServersString[$i]['server']); // explode servers string from 'id-id-id-id' to get id ^^
            foreach ($output as $opt)
                if (!in_array($opt, $avaibleServers)) // add server to array if he isn't inside
                    array_push($avaibleServers, $serversRepo->find($opt));
        }

        // render this
        return $this->render('frontend/services/index.html.twig', [
            'title' => 'Informacje o usłudze '.$service->getName(),
            'breadcrumbs' => array(),
            'services' => $services,
            'servers' => $servers,
            'service' => $service,
            'bought' => $bought,
            'bestPrice' => $bestPrice,
            'last_buyer' => $lastBuyerName,
            'avaibleServers' => $avaibleServers
        ]);
    }
}