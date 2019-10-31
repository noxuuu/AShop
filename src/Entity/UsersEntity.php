<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 07.01.2019
 * Time: 00:31
 */

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\Role;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @ORM\Table(name="ashop_users")
 * @UniqueEntity(fields="email", message="Email jest już w użyciu")
 * @UniqueEntity(fields="username", message="Login jest już w użyciu")
 * @UniqueEntity(fields="authData", message="Steam ID jest już w użyciu")
 */
class UsersEntity implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="array")
     */
    protected $roles;

    /**
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumn(name="groupId", referencedColumnName="id", nullable=true)
     */
    private $groupId;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     */
    protected $steamId;

    /**
     * @ORM\Column(type="float")
     */
    private $wallet;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $joinDate;

    public function __construct()
    {
        $this->isActive = true;
        $this->roles = array('ROLE_USER');
        $this->wallet = 0.00;

        try {
            $this->joinDate = new DateTime();
        } catch (\Exception $e) {
        }
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function serialize()
    {
        return serialize(array(
            $this->username,
            $this->password,
            $this->isActive,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->username,
            $this->password,
            $this->isActive,
            ) = unserialize($serialized);
    }



    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRoles() :array
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = new Role($role);
        }

        // todo delete roles from user entity, add roles in groups - create alternative named permissions and save it like array
        return $roles;
    }

    /**
     * @return mixed
     */
    public function getAuthData()
    {
        return $this->steamId;
    }

    /**
     * @param mixed $authData
     */
    public function setAuthData($authData): void
    {
        $this->steamId = $authData;
    }

    /**
     * @return mixed
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param mixed $wallet
     */
    public function setWallet($wallet): void
    {
        $this->wallet = $wallet;
    }

    /**
     * {@inheritdoc}
     */
    public function setJoinDate(?int $joinDate): void
    {
        if (null !== $joinDate) {
            $joinDateDate = new \DateTime();
            $joinDateDate->setTimestamp($joinDate);
            $joinDate = $joinDateDate;
        }

        $this->joinDate = $joinDate;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId($groupId): void
    {
        $this->groupId = $groupId;
    }
}