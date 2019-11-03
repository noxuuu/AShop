<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:37
 */

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class statsController extends AbstractController
{
    /**
     * @Route("/admin/stats", name="admin_stats")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function stats()
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/stats.html.twig');
    }
}