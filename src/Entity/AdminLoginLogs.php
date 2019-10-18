<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 00:05
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminLoginLogsRepository")
 * @ORM\Table(name="ashop_admin_login_logs")
 * @UniqueEntity(fields="id")
 */
class AdminLoginLogs
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
    private $adminName; // klucz obcy dla ashop_users.username

    /**
    * @ORM\Column(type="string", nullable=true, options={"default": NULL})
    */
    private $adminIp;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $success;

    /**
     * @return mixed
     */
    public function getAdminName()
    {
        return $this->adminName;
    }

    /**
     * @return mixed
     */
    public function getAdminIp()
    {
        return $this->adminIp;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}