<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 11:03
 */

namespace App\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

class UsersRepository extends EntityRepository implements UserLoaderInterface
{
    /**
     * Retrieves number of rows
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countEm()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('count(u.username) AS counter');
        $query = $qb->getQuery();
        return $query->getSingleScalarResult();
    }

    /**
     * Retrieves last registrations
     * @param $max
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastRegistrations($max){
        $qb = $this->createQueryBuilder('u');
        $qb->select('u.username', 'g.style', 'u.authData', 'u.joinDate')
            ->join('u.groupId', 'g', 'WITH', 'u.groupId = g.id')
            ->orderBy('u.joinDate', 'DESC')
            ->setMaxResults($max);
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}