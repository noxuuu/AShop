<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:34
 */

namespace App\Controller\admin;

use App\Service\logService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class vouchersController extends AbstractController
{
    private $logService;

    public function __construct(logService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * @Route("/admin/vouchers", name="admin_vouchers")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function vouchersController()
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/vouchers.html.twig');
    }
}