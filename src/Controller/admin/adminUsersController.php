<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:40
 */

namespace App\Controller\admin;

use App\Entity\UsersEntity;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class adminUsersController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function users(PaginatorInterface $paginator, Request $request)
    {
        // === Get repo for query ===
        $usersRepo = $this->getDoctrine()->getRepository(UsersEntity::class);


        return $this->render('admin/users.html.twig', [
            'pagination' => $paginator->paginate($usersRepo->findAll(), $request->query->getInt('page', 1), 30)
        ]);
    }
}