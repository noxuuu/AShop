<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:39
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class PaymentMethodRepository extends EntityRepository
{
    /**
     * Retrieves servers id string like 'id-id-id-id'
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function GetAvaibleServersForService($id){
        $qb = $this->createQueryBuilder('p');
        $qb->select('p.server')
            ->where('p.service = :service')
            ->setParameter('service', $id);
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    /**
     * Retrieves payment method by id
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findById($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}