<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 05:59
 */

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Controller for admin common.
 *
 * Class dashboardController
 * @package App\Controller
 */
class dashboardController extends AbstractController
{
    /**
     * Get admin dashboard
     *
     * @Route("/admin/", name="admin")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function dashboard()
    {
        return $this->render('admin/dashboard.html.twig');
    }
}