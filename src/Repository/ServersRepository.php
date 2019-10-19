<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:39
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class ServersRepository extends EntityRepository
{
    /**
     * Retrieves servers names and equal id
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getServersNamesAndId(){
        $qb = $this->createQueryBuilder('s');
        $qb->select('s.id', 's.name');
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }
}