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
     * Retrieves number of rows
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countEm()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('count(u.id) AS counter');
        $query = $qb->getQuery();
        return $query->getSingleScalarResult();
    }

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

            $userService = new UserServices();
            $userService->setServerId($server);
            $userService->setServiceId($price->getServiceId());
            $userService->setAuthData($authData);
            $userService->setValue($price->getValue());
            $userService->setBoughtDate($time);
            $userService->setExpires($expires->setTimestamp($time->getTimestamp() + ($price->getValue() * 86400)));

            $entityManager = $this->getEntityManager();
            $entityManager->persist($userService);
            $entityManager->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}