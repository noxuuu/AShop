<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:40
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class SettingsRepository extends EntityRepository
{
    public function findByName($name)
    {
        return $this->createQueryBuilder('s')
            ->where('s.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }
}