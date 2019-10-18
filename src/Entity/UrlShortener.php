<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 01:09
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UrlShortenerRepository")
 * @ORM\Table(name="ashop_url_shortener")
 * @UniqueEntity(fields="id")
 */
class UrlShortener
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private $oryginalUrl;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $newUrl;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expires;

    /**
     * @return mixed
     */
    public function getOryginalUrl()
    {
        return $this->oryginalUrl;
    }

    /**
     * @param mixed $oryginalUrl
     */
    public function setOryginalUrl($oryginalUrl): void
    {
        $this->oryginalUrl = $oryginalUrl;
    }

    /**
     * @return mixed
     */
    public function getNewUrl()
    {
        return $this->newUrl;
    }

    /**
     * @param mixed $newUrl
     */
    public function setNewUrl($newUrl): void
    {
        $this->newUrl = $newUrl;
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}