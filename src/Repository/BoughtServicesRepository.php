<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:38
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class BoughtServicesRepository extends EntityRepository
{
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
}