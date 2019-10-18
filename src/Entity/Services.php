<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 01:02
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServicesRepository")
 * @ORM\Table(name="ashop_services")
 * @UniqueEntity(fields="id")
 */
class Services
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $webDescription;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $serverDescription;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $sufix;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $flags;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderNumber;

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
    public function getWebDescription()
    {
        return $this->webDescription;
    }

    /**
     * @param mixed $webDescription
     */
    public function setWebDescription($webDescription): void
    {
        $this->webDescription = $webDescription;
    }

    /**
     * @return mixed
     */
    public function getServerDescription()
    {
        return $this->serverDescription;
    }

    /**
     * @param mixed $serverDescription
     */
    public function setServerDescription($serverDescription): void
    {
        $this->serverDescription = $serverDescription;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return mixed
     */
    public function getSufix()
    {
        return $this->sufix;
    }

    /**
     * @param mixed $sufix
     */
    public function setSufix($sufix): void
    {
        $this->sufix = $sufix;
    }

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
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @param mixed $flags
     */
    public function setFlags($flags): void
    {
        $this->flags = $flags;
    }

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param mixed $orderNumber
     */
    public function setOrderNumber($orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}