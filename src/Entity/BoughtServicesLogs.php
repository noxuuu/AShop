<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 07/01/2019
 * Time: 00:13
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoughtServicesRepository")
 * @ORM\Table(name="ashop_bought_services_logs")
 * @UniqueEntity(fields="id")
 */
class BoughtServicesLogs
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @ORM\JoinColumn(name="paymentMethod", referencedColumnName="id", nullable=true)
     */
    private $paymentMethodId; // klucz obcy dla ashop_payment_methods.id

    /**
     * @ORM\ManyToOne(targetEntity="UsersEntity")
     * @ORM\JoinColumn(name="adminName", referencedColumnName="username", nullable=true)
     */
    private $userId; // klucz obcy dla ashop_users.id

    /**
     * @ORM\ManyToOne(targetEntity="Servers")
     * @ORM\JoinColumn(name="server", referencedColumnName="id", nullable=true)
     */
    private $server; // klucz obcy dla ashop_servers.id

    /**
     * @ORM\ManyToOne(targetEntity="Services")
     * @ORM\JoinColumn(name="service", referencedColumnName="id", nullable=true)
     */
    private $service; // klucz obcy dla ashop_services.id

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
     * @ORM\Column(type="string", nullable=true, options={"default": NULL})
     */
    private $userIp;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

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
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * @param mixed $serverId
     */
    public function setServerId($serverId): void
    {
        $this->serverId = $serverId;
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
    public function getUserIp()
    {
        return $this->userIp;
    }

    /**
     * @param mixed $userIp
     */
    public function setUserIp($userIp): void
    {
        $this->userIp = $userIp;
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