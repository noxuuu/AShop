<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:41
 */

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class groupsController extends AbstractController
{
    /**
     * @Route("/admin/groups", name="admin_groups")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function groups()
    {
        return $this->render('admin/groups.html.twig');
    }
}