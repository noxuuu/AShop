<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:41
 */

namespace App\Controller\admin;

use App\Entity\Groups;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class groupsController extends AbstractController
{
    /**
     * @Route("/admin/groups", name="admin_groups")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function groups(PaginatorInterface $paginator, Request $request)
    {
        // === Get repo for query ===
        $usersRepo = $this->getDoctrine()->getRepository(Groups::class);


        return $this->render('admin/groups.html.twig', [
            'pagination' => $paginator->paginate($usersRepo->findAll(), $request->query->getInt('page', 1), 30)
        ]);
        // todo Add users count
        // todo make permisions

    }
}