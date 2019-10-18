<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:41
 */

namespace App\Repository;

use App\Entity\Prices;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\UserServices;
use Doctrine\ORM\EntityRepository;


class UserServicesRepository extends EntityRepository
{
    /**
     * @param $priceId
     * @param Servers $server
     * @param $authData
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * 
     */
    public function addService($priceId, Servers $server, $authData){
        $pricesRepo = $this->getEntityManager()->getRepository(Prices::class);
        $price = $pricesRepo->findOneBy(['id' => $priceId]);

        if(!$price)
            return false;

        try{
            $time = new \DateTime();
            $expires = new \DateTime();
            $expires->setTimestamp($time->getTimestamp() + $price->getValue()*864000);

            $userService = new UserServices();
            $userService->setServerId($server->getId());
            $userService->setServiceId($price->getServiceId()->getId());
            $userService->setAuthData($authData);
            $userService->setValue($price->getValue());
            $userService->setBoughtDate($time);
            $userService->setExpires($expires);

            $entityManager = $this->getEntityManager();
            $entityManager->persist($userService);
            $entityManager->flush();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}