<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 18/10/2019
 * Time: 10:51
 */

namespace App\Service\admin;


use App\Entity\Groups;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Tariffs;
use Doctrine\ORM\EntityManagerInterface;

class typeFunctions
{
    private $serversRepo;
    private $servicesRepo;
    private $tariffsRepo;
    private $groupsRepo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->serversRepo = $entityManager->getRepository(Servers::class);
        $this->servicesRepo = $entityManager->getRepository(Services::class);
        $this->tariffsRepo = $entityManager->getRepository(Tariffs::class);
        $this->groupsRepo = $entityManager->getRepository(Groups::class);
    }

    function loadServersToChoiceList()
    {
        $servers = $this->serversRepo->getServersNamesAndId();

        $choiceList = array();
        foreach ($servers as $server)
            $choiceList[$server['name']] = $server['id'];

        return $choiceList;
    }

    function loadServicesToChoiceList(bool $exclude_apis = false)
    {
        $services = $this->servicesRepo->getServicesNamesAndId($exclude_apis);

        $choiceList = array();
        foreach ($services as $service)
            $choiceList[$service['name']] = $service['id'];

        return $choiceList;
    }

    function loadTariffsToChoiceList()
    {
        $tariffs = $this->tariffsRepo->getTariffsVisualisation();
        $choiceList = array();
        foreach ($tariffs as $tariff) {

            $tariff['name'] = $tariff['name'].' - '.$tariff['brutto'].'zł';

            if($tariff['type'] == 1)
                $tariff['name'] = $tariff['name'].' - '.$tariff['smsNumber'];

            $choiceList[$tariff['name']] = $tariff['id'];
        }

        return $choiceList;
    }

    function loadGroupsToChoiceList()
    {
        $groups = $this->groupsRepo->getGroupsNamesAndId();

        $choiceList = array();
        foreach ($groups as $group)
            $choiceList[$group['name']] = $group['id'];

        return $choiceList;
    }
}