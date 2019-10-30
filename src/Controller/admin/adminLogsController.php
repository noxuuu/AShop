<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:43
 */

namespace App\Controller\admin;

use App\Entity\AdminLogs;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class adminLogsController extends AbstractController
{
    /**
     * @Route("/admin/logs/admin", name="admin_logs")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminLogs(PaginatorInterface $paginator, Request $request)
    {
        // === Get repo for query ===
        $logsRepo = $this->getDoctrine()->getRepository(AdminLogs::class);


        return $this->render('admin/logs/adminlogs.html.twig', [
            'pagination' => $paginator->paginate($logsRepo->findAll(), $request->query->getInt('page', 1), 30)
        ]);
    }
}