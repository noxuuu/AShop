<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:34
 */

namespace App\Controller\admin;

use App\Entity\Prices;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Settings;
use App\Entity\Vouchers;
use App\Form\admin\vouchersType;
use App\Service\logService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function vouchersController(Request $request, PaginatorInterface $paginator)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for queries ===
        $vouchersRepo = $this->getDoctrine()->getRepository(Vouchers::class);
        $pricesRepo = $this->getDoctrine()->getRepository(Prices::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);

        // create and handle form
        $voucher = new Vouchers();
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(vouchersType::class, $voucher);
        $form_add->handleRequest($request);

        if ($form_add->isSubmitted() && $form_add->isValid()) {
            // get form data
            $formData = $form_add->getData();

            // === Flush to DataBase! ===
            try {
                // save progress!
                $voucher->setPriceId($pricesRepo->find($formData->getPriceId()));
                $entityManager->persist($voucher);
                $entityManager->flush();

                $this->addFlash('add_success', 'Dodano poprawnie!');
                $this->logService->logAction('add', 'Dodano nowy voucher');
            } catch (Exception $e) {
                $this->addFlash('add_error', 'Wystąpił niespodziewany błąd.');
            }
            return $this->redirectToRoute('admin_vouchers');
        }

        return $this->render('admin/vouchers.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'title' => 'Kody promocyjne',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Zarządzanie', '#'],
                ['Vouchery', $this->generateUrl('admin_vouchers')]
            ],
            'pagination' => $paginator->paginate($vouchersRepo->findAll(), $request->query->getInt('page', 1), 20),
            'servers' => $serversRepo->findAll(),
            'services' => $servicesRepo->findAll(),
            'form_add' => $form_add->createView()
        ]);
    }

    /**
     * @Route("/admin/vouchers/delete/{id}", name="delete_voucher")
     * @return JsonResponse
     * @throws \Exception
     */
    public function deletePrice(Request $request, $id)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $voucher = $this->getDoctrine()->getRepository(Vouchers::class)->find($id);

            if($voucher)
            {
                $entityManager->remove($voucher);
                $entityManager->flush();

                $data[1] = true;
                $this->logService->logAction('delete', 'Usunięto voucher.');
            }
            else
                $data[1] = false;

        } catch (\Exception $e) {
            $data[1] = false;
        }

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($data);
        else
            throw new \Exception('Not allowed usage');
    }
}