<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:32
 */

namespace App\Controller\admin;

use App\Entity\Servers;
use App\Form\admin\serversType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class serversController extends AbstractController
{
    /**
     * @Route("/admin/servers", name="admin_servers")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function adminServers(PaginatorInterface $paginator, Request $request)
    {
        // === Get repo for query ===
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);

        // === Create Form ===
        $server = new Servers();
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(serversType::class, $server);
        $form_edit = $this->createForm(serversType::class, $server);
        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {

            $server->setConnected(false);

            $entityManager->persist($server);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nowy serwer!');

            return $this->redirectToRoute('admin_servers');
        }

        return $this->render('admin/servers.html.twig', [
            'form_add' => $form_add->createView(),
            'form_edit' => $form_edit,
            'pagination' => $paginator->paginate($serversRepo->findAll(),$request->query->getInt('page', 1),30)
        ]);
    }

    /**
     * @Route("/admin/servers/{server}/edit", name="edit_server")
     * @Entity("server", expr="repository.find(server)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editServer(Request $request, Servers $server)
    {
        $serverName = $server->getName();

        $editForm = $this->createForm(serversType::class, $server);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $this->addFlash('edit_success', 'Edytowano '.$serverName.'!');

            } catch (\Exception $e) {
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }

        return $this->redirectToRoute('admin_servers');
    }


    /**
     * @Route("/admin/servers/delete/{id}", name="delete_server", requirements={"id"="\d+"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteServer($id)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $server = $this->getDoctrine()->getRepository(Servers::class)->find($id);

            $serverName = $server->getName();

            $entityManager->remove($server);
            $entityManager->flush();

            $this->addFlash('delete_success', 'Usunięto '.$serverName.'!');

        } catch (\Exception $e) {
            $this->addFlash('delete_error', 'Wystąpił niespodziewany błąd.');
        }

        return $this->redirectToRoute('admin_servers');
    }
}