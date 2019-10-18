<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:35
 */

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class userServicesController extends AbstractController
{
    /**
     * @Route("/admin/users_services", name="admin_usersServices")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function userServices()
    {
        return $this->render('admin/usersservices.html.twig');
    }
}