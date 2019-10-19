<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:40
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class TariffsRepository extends EntityRepository
{
    /**
     * Retrieves tariffs data
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTariffsVisualisation(){
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.id', 't.brutto', 't.smsNumber', 'm.name', 'm.type')
            ->join('t.paymentMethodId', 'm', 'WITH', 't.paymentMethodId = m.id');
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }
}