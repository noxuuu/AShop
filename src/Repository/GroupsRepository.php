<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:38
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class GroupsRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getGroupsNamesAndId(){
        $qb = $this->createQueryBuilder('g');
        $qb->select('g.id', 'g.name');
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }
}