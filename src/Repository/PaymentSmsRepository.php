<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 19:38
 */

namespace App\Repository;

use App\Entity\PaymentMethod;
use App\Entity\PaymentsSMS;
use App\Entity\Tariffs;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;


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

    public function logPayment(Tariffs $tariff, PaymentMethod $method, $code){
        try{
            $time = new \DateTime();
            $payment = new PaymentsSMS();
            $request = Request::createFromGlobals();

            $payment->setIncome($tariff->getNetto());
            $payment->setCost($tariff->getBrutto());
            $payment->setNumber($tariff->getSmsNumber());
            $payment->setCode($code);
            $payment->setPaymentMethodId($method);
            $payment->setPlatform('www');
            $payment->setIp($request->getClientIp());
            $payment->setDate($time);

            $entityManager = $this->getEntityManager();
            $entityManager->persist($payment);
            $entityManager->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}