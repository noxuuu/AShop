<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 01:08
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TariffsRepository")
 * @ORM\Table(name="ashop_tariffs")
 * @UniqueEntity(fields="id")
 */
class Tariffs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @ORM\JoinColumn(name="paymentMethod", referencedColumnName="id", nullable=true)
     */
    private $paymentMethodId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank()
     */
    private $smsNumber;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     */
    private $brutto;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     */
    private $netto;

    /**
     * @return mixed
     */
    public function getPaymentMethodId()
    {
        return $this->paymentMethodId;
    }

    /**
     * @param mixed $paymentMethodId
     */
    public function setPaymentMethodId($paymentMethodId): void
    {
        $this->paymentMethodId = $paymentMethodId;
    }

    /**
     * @return mixed
     */
    public function getSmsNumber()
    {
        return $this->smsNumber;
    }

    /**
     * @param mixed $smsNumber
     */
    public function setSmsNumber($smsNumber): void
    {
        $this->smsNumber = $smsNumber;
    }

    /**
     * @return mixed
     */
    public function getBrutto()
    {
        return $this->brutto;
    }

    /**
     * @param mixed $brutto
     */
    public function setBrutto($brutto): void
    {
        $this->brutto = $brutto;
    }

    /**
     * @return mixed
     */
    public function getNetto()
    {
        return $this->netto;
    }

    /**
     * @param mixed $netto
     */
    public function setNetto($netto): void
    {
        $this->netto = $netto;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}