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
    /**
     * Retrieves tariffs data
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTariffInfo($id){
        $qb = $this->createQueryBuilder('t');
        $qb->select('m.smskey', 't.smsNumber', 't.brutto')
            ->join('t.paymentMethodId', 'm', 'WITH', 't.paymentMethodId = m.id')
            ->where('t.id = :id')
            ->setParameter('id', $id);
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }

    /**
     * Returns values for specific payment type given
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function GetPaymentTypeValues($paymentType){
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.id', 't.brutto', 't.netto')
            ->join('t.paymentMethodId', 'm', 'WITH', 't.paymentMethodId = m.id')
            ->where('m.type = :type')
            ->setParameter('type', $paymentType)
            ->orderBy('t.brutto', 'DESC');
        $query = $qb->getQuery();
        return $query->getArrayResult();
    }
}