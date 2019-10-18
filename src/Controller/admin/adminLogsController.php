<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:43
 */

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class adminLogsController extends AbstractController
{
    /**
     * @Route("/admin/logs/admin", name="admin_logs")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminLogs()
    {
        return $this->render('admin/adminlogs.html.twig');
    }
}