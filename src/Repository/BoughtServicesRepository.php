<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:38
 */

namespace App\Repository;

use App\Entity\BoughtServicesLogs;
use App\Entity\Prices;
use App\Entity\Servers;
use App\Entity\UsersEntity;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;


class BoughtServicesRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->findBy(array(), array('date' => 'DESC'));
    }

    /**
     * Retrieves number of rows
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countEm()
    {
        $qb = $this->createQueryBuilder('b');
        $qb->select('count(b.id) AS counter');
        $query = $qb->getQuery();
        return $query->getSingleScalarResult();
    }

    /**
     * Retrieves number of rows
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countEmDistinct($service)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->select('count(b.id) AS counter')
            ->join('b.service', 's', 'WITH', 'b.service = s.id')
            ->where('s.name = :service')
            ->setParameter('service', $service);
        $query = $qb->getQuery();
        return $query->getSingleScalarResult();
    }


    /**
     * Retrieves number of rows with service with our id
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countEmByService($id)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->select('count(b.id) AS counter')
            ->where('b.service = :id')
            ->setParameter('id', $id);
        $query = $qb->getQuery();
        return $query->getSingleScalarResult();
    }


    /**
     * Retrieves last record
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLastRecord()
    {
        $qb = $this->createQueryBuilder('b');
        $qb->orderBy('b.date', 'DESC')
            ->setMaxResults(1);
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    /**
     * Retrieves last record by service id
     * @param $service
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLastRecordByService($id)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->where('b.service = :service')
            ->setParameter('service', $id)
            ->orderBy('b.date', 'DESC')
            ->setMaxResults(1);
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    /**
     * Retrieves last registrations
     * @param $max
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastPucharses($max){
        $qb = $this->createQueryBuilder('b');
        $qb->orderBy('b.date', 'DESC')
            ->setMaxResults($max);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * Retrieves distinct services
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAllDistinct()
    {
        $qb = $this->createQueryBuilder('b');
        $qb->select('DISTINCT s.name')
            ->join('b.service', 's', 'WITH', 'b.service = s.id');
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    /**
     * @param $priceId
     * @param Servers $server
     * @param $authData
     * @param $paymentType
     * @param UsersEntity $user
     * @return bool
     */
    public function logServiceBuy($priceId, Servers $server, $authData, $paymentType, UsersEntity $user){
        $pricesRepo = $this->getEntityManager()->getRepository(Prices::class);
        $price = $pricesRepo->findOneBy(['id' => $priceId]);

        if(!$price)
            return false;

        try{
            $time = new \DateTime();
            $log = new BoughtServicesLogs();
            $request = Request::createFromGlobals();

            if($user)
                $log->setUserId($user);
            
            $log->setServerId($server);
            $log->setServiceId($price->getServiceId());
            $log->setPaymentType($paymentType);
            $log->setValue($price->getValue());
            $log->setAuthData($authData);
            $log->setUserIp($request->getClientIp());
            $log->setDate($time);

            $entityManager = $this->getEntityManager();
            $entityManager->persist($log);
            $entityManager->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}