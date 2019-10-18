<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 00:53
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PricesRepository")
 * @ORM\Table(name="ashop_prices")
 * @UniqueEntity(fields="id")
 */
class Prices
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Services")
     * @ORM\JoinColumn(name="service", referencedColumnName="id", nullable=true)
     */
    private $service;

    /**
     * @ORM\Column(type="string", nullable=true, options={"default": NULL})
     */
    private $server;

    /**
     * @ORM\ManyToOne(targetEntity="Tariffs")
     * @ORM\JoinColumn(name="tariff", referencedColumnName="id", nullable=true)
     */
    private $tariff; // klucz obcy dla ashop_tariffs.id

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $value;

    /**
     * @return mixed
     */
    public function getServiceId()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setServiceId($service): void
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getServerId()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     */
    public function setServerId($server): void
    {
        $this->server = $server;
    }

    /**
     * @return mixed
     */
    public function getTariffId()
    {
        return $this->tariff;
    }

    /**
     * @param mixed $tariff
     */
    public function setTariffId($tariff): void
    {
        $this->tariff = $tariff;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}