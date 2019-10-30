<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 06/01/2019
 * Time: 23:01
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminLogsRepository")
 * @ORM\Table(name="ashop_admin_logs")
 * @UniqueEntity(fields="id")
 */
class AdminLogs
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UsersEntity")
     * @ORM\JoinColumn(name="adminName", referencedColumnName="username", nullable=true)
     */
    private $adminName;

    /**
     * @ORM\Column(type="string", nullable=true, options={"default": NULL})
     */
    private $adminIp;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @return mixed
     */
    public function getAdminName()
    {
        return $this->adminName;
    }

    /**
     * @param mixed $adminName
     */
    public function setAdminName($adminName): void
    {
        $this->adminName = $adminName;
    }

    /**
     * @return mixed
     */
    public function getAdminIp()
    {
        return $this->adminIp;
    }

    /**
     * @param mixed $adminIp
     */
    public function setAdminIp($adminIp): void
    {
        $this->adminIp = $adminIp;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}