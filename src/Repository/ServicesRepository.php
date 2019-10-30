<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 08/01/2019
 * Time: 22:03
 */

namespace App\Repository;

use App\Entity\Services;
use Doctrine\ORM\EntityRepository;

class ServicesRepository extends EntityRepository
{
    public function findByName($name)
    {
        return $this->createQueryBuilder('s')
            ->where('s.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Retrieves services names and equal id
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getServicesNamesAndId(bool $exclude_apis = false){
        $qb = $this->createQueryBuilder('s');

        if($exclude_apis)
            $qb->select('s.id', 's.name')
            ->where('s.type != 3')
            ->andWhere('s.type != 4'); // exclude api services and minecraft cause that could get bugged
        else
            $qb->select('s.id', 's.name');

        $query = $qb->getQuery();
        return $query->getArrayResult();
    }
}