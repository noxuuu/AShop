<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:35
 */

namespace App\Controller\admin;

use App\Entity\Servers;
use App\Entity\UserServices;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class userServicesController extends AbstractController
{
    /**
     * @Route("/admin/users_services", name="admin_usersServices")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function userServices(PaginatorInterface $paginator, Request $request)
    {
        // === Get repo for query ===
        $usRepo = $this->getDoctrine()->getRepository(UserServices::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);

        return $this->render('admin/usersservices.html.twig', [
            'pagination' => $paginator->paginate($usRepo->findAll(),$request->query->getInt('page', 1),30),
            'servers' => $serversRepo->findAll(),
            'search_results' => false // to do actually
        ]);
    }
}