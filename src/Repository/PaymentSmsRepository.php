<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:38
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class PaymentSmsRepository extends EntityRepository
{
    /**
     * Retrieves number of rows
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countEm()
    {
        $qb = $this->createQueryBuilder('l');
        $qb->select('count(l.id) AS counter');
        $query = $qb->getQuery();
        return $query->getSingleScalarResult();
    }
}