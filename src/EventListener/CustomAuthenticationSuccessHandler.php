<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 07/12/2019
 * Time: 07:09
 */

namespace App\EventListener;

use App\Entity\AdminLoginLogs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class CustomAuthenticationSuccessHandler {

    private $em;
    private $userIP;
    private $security;

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack, Security $security)
    {
        $this->em = $em;
        $this->security = $security;

        if($requestStack->getMasterRequest())
            $this->userIP = $requestStack->getMasterRequest()->getClientIp();
    }

    public function onAuthenticationSuccess(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if($this->security->isGranted('ROLE_ADMIN')) {
            $log = new AdminLoginLogs();
            $log->setAdminName($user);
            $log->setAdminIp($this->userIP);
            $log->setDate(new \DateTime());
            $log->setSuccess(true);

            $this->em->persist($log);
            $this->em->flush();
        }
    }
}