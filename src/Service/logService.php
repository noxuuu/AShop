<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 07/12/2019
 * Time: 04:39
 */

namespace App\Service;

use App\Entity\AdminLoginLogs;
use App\Entity\AdminLogs;
use App\Entity\BoughtServicesLogs;
use App\Entity\PaymentsPSC;
use App\Entity\PaymentsSMS;
use App\Entity\PaymentsTransfer;
use App\Entity\UsersEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class logService
{
    private $entityManager;
    private $usersRepo;
    private $user;
    private $userIp;

    private $admin;
    private $adminLogin;
    private $boughtServices;
    private $pmSMS;
    private $pmPSC;
    private $pmTransfer;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->user = $tokenStorage->getToken()->getUser();
        $this->userIp = $requestStack->getMasterRequest()->getClientIp();

        $this->admin = $entityManager->getRepository(AdminLogs::class);
        $this->adminLogin = $entityManager->getRepository(AdminLoginLogs::class);
        $this->boughtServices = $entityManager->getRepository(BoughtServicesLogs::class);
        $this->pmSMS = $entityManager->getRepository(PaymentsSMS::class);
        $this->pmPSC = $entityManager->getRepository(PaymentsPSC::class);
        $this->pmTransfer = $entityManager->getRepository(PaymentsTransfer::class);
        $this->usersRepo = $entityManager->getRepository(UsersEntity::class);
    }

    function logAction($type, $content){

        $action = new AdminLogs();
        $action->setContent($content);
        $action->setAdminIp($type == "servicesManager" ? "SYSTEM" : $this->userIp);
        $action->setAdminName($type == "servicesManager" ? $this->usersRepo->findOneBy(['username' => 'SYSTEM']) : $this->user);
        $action->setDate(new \Datetime());

        try {
            $this->entityManager->persist($action);
            $this->entityManager->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}