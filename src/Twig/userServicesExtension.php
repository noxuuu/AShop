<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 19/10/2019
 * Time: 03:42
 */

namespace App\Twig;

use App\Entity\UsersEntity;
use App\Entity\UserServices;
use App\Service\steamAuthService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class userServicesExtension extends AbstractExtension
{
    /**
     * @var EntityRepository
     */
    private $repository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var steamAuthService
     */
    private $steamAuth;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * TemporaryEmailRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, steamAuthService $steamAuth)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(UserServices::class);
        $this->tokenStorage = $tokenStorage;
        $this->steamAuth = $steamAuth;
    }

    /**
     * @return array|TwigFilter[]|\Twig_Filter[]
     */
    public function getFilters()
    {

        return [
            new TwigFilter('get_service_progressbar', [$this, 'getProgress'], array('is_safe' => array('html'))),
            new TwigFilter('getUserName', [$this, 'getUserName'], array('is_safe' => array('html'))),
        ];
    }

    /**
     * @param $service
     * @return string
     */
    public function getProgress($service)
    {
        $date = new \DateTime();
        $current_timestamp = $date->getTimestamp();
        $bought_timestamp = $service->getBoughtDate()->getTimestamp();
        $expires_timestamp = $service->getExpires()->getTimestamp();

        $percent = round(100 - ( ($current_timestamp - $bought_timestamp) /($expires_timestamp - $bought_timestamp) ) * 100);

        if($percent >= 60) $style = 'success';
        else if($percent >= 25) $style = 'warning';
        else $style = 'danger';


        return '<div class="progress-bar progress-bar-'.$style.'" style="width: '.$percent.'%"></div>';
    }
    /**
     * @param $authData
     * @return string
     */
    public function getUserName($authData)
    {
        // get user
        $user = $this->tokenStorage->getToken()->getUser();

        // check wheter user auth match given auth and display name or - find in steam
        if($user->getAuthData() == $authData)
            return '<span style="'.$user->getGroupId()->getStyle().'">'.$user->getUsername().'</span>';

        if($found = $this->entityManager->getRepository(UsersEntity::class)->findOneBy(['authData' => $authData]))
            return $found->getUsername();

        return $this->steamAuth->getUserName($this->steamAuth->toCommunityID($authData));
    }
}















