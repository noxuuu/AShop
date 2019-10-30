<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:38
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class AdminLogsRepository extends EntityRepository
{
    /**
     * Retrieves last activity
     * @param $max
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLastActivity($max){
        $qb = $this->createQueryBuilder('l');
        $qb->select('IDENTITY(l.adminName) as admin', 'l.content', 'l.date')
            ->orderBy('l.date', 'DESC')
            ->setMaxResults($max);
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }
}