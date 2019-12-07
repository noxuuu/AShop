<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 06.01.2019
 * Time: 23:50
 */

namespace App\Service\shop;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class securityService
{
    public function login(AuthenticationUtils $authenticationUtils) : array {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return[
            'error' => $error,
            'lastUsername' => $lastUsername
        ];
    }

}