<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 01:11
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserServicesRepository")
 * @ORM\Table(name="ashop_user_services")
 * @UniqueEntity(fields="id")
 */
class UserServices
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Servers")
     * @ORM\JoinColumn(name="server", referencedColumnName="id", nullable=true)
     */
    private $server;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Services")
     * @ORM\JoinColumn(name="service", referencedColumnName="id", nullable=true)
     */
    private $service;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $value;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $authData;

    /**
     * @ORM\Column(type="datetime")
     */
    private $boughtDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expires;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getAuthData()
    {
        return $this->authData;
    }

    /**
     * @param mixed $authData
     */
    public function setAuthData($authData): void
    {
        $this->authData = $authData;
    }

    /**
     * @return mixed
     */
    public function getBoughtDate()
    {
        return $this->boughtDate;
    }

    /**
     * @param mixed $boughtDate
     */
    public function setBoughtDate($boughtDate): void
    {
        $this->boughtDate = $boughtDate;
    }

    /**
     * @return mixed
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param mixed $expires
     */
    public function setExpires($expires): void
    {
        $this->expires = $expires;
    }

}