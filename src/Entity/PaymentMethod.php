<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 00:10
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="ashop_payment_methods")
 * @ORM\Entity(repositoryClass="App\Repository\PaymentMethodRepository")
 * @UniqueEntity(fields="id")
 */
class PaymentMethod
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    private $smskey;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $apikey;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $apisecret;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $serviceId;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $methodName;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSmskey()
    {
        return $this->smskey;
    }

    /**
     * @param mixed $smskey
     */
    public function setSmskey($smskey): void
    {
        $this->smskey = $smskey;
    }

    /**
     * @return mixed
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * @param mixed $apikey
     */
    public function setApikey($apikey): void
    {
        $this->apikey = $apikey;
    }

    /**
     * @return mixed
     */
    public function getApisecret()
    {
        return $this->apisecret;
    }

    /**
     * @param mixed $apisecret
     */
    public function setApisecret($apisecret): void
    {
        $this->apisecret = $apisecret;
    }

    /**
     * @return mixed
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @param mixed $serviceId
     */
    public function setServiceId($serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    /**
     * @return mixed
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param mixed $methodName
     */
    public function setMethodName($methodName): void
    {
        $this->methodName = $methodName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}