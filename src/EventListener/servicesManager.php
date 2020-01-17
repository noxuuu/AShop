<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 17/01/2020
 * Time: 03:01
 */

namespace App\EventListener;


use App\Entity\UserServices;
use App\Service\logService;
use Doctrine\ORM\EntityManagerInterface;

class servicesManager
{
    private $entityManager;
    private $logService;

    public function __construct(EntityManagerInterface $entityManager, logService $logService)
    {
        $this->entityManager = $entityManager;
        $this->logService = $logService;
    }

    public function deleteInactiveServices(){
        // get repo
        $servicesRepo = $this->entityManager->getRepository(UserServices::class);

        // get some data
        $date = new \DateTime();
        $services = $servicesRepo->findAll();

        // loop services and delete inactive
        foreach ($services as $service) {
            if($service->getExpires() < $date){
                $this->entityManager->remove($service);
                $this->entityManager->flush();

                $this->logService->logAction('servicesManager', 'Usunięto wygasłą usługę gracza [#'.$service->getAuthData().'] [#'.$service->getServiceId()->getName().'] [#'.$service->getServerId()->getName().']');
            }
        }
    }
}