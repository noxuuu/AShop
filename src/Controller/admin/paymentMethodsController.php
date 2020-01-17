<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:29
 */

namespace App\Controller\admin;

use App\Entity\PaymentMethod;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Settings;
use App\Form\admin\payment_methods\pmAddType_1s1k;
use App\Form\admin\payment_methods\pmAddType_cssetti;
use App\Form\admin\payment_methods\pmAddType_gosetti;
use App\Form\admin\payment_methods\pmAddType_hostplay;
use App\Form\admin\payment_methods\pmAddType_liveserver;
use App\Form\admin\payment_methods\pmAddType_microsms;
use App\Form\admin\payment_methods\pmAddType_p24psc;
use App\Form\admin\payment_methods\pmAddType_p24sms;
use App\Form\admin\payment_methods\pmAddType_p24transfer;
use App\Form\admin\payment_methods\pmAddType_pukawka;
use App\Form\admin\payment_methods\pmAddType_tpay;
use App\Form\admin\payment_methods\pmEditType;
use App\Service\logService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class paymentMethodsController extends AbstractController
{
    private $logService;

    public function __construct(logService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * @Route("/admin/payment_methods", name="admin_pm")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function paymentMethods(PaginatorInterface $paginator, Request $request)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for query ===
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);
        $pmRepo = $this->getDoctrine()->getRepository(PaymentMethod::class);

        // === Create Forms ===
        $method = new PaymentMethod();
        $entityManager = $this->getDoctrine()->getManager();

        $form_add_1s1k = $this->createForm(pmAddType_1s1k::class, $method);
        $form_add_1s1k->handleRequest($request);

        if ($form_add_1s1k->isSubmitted() && $form_add_1s1k->isValid()) {
            $method->setMethodName('oneshotonekill');
            $method->setType(1);

            $entityManager->persist($method);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową metode płatności!');
            $this->logService->logAction('add', 'Dodano nową metode płatności [1s1k - SMS]');

            return $this->redirectToRoute('admin_pm');
        }

        $form_add_pukawka = $this->createForm(pmAddType_pukawka::class, $method);
        $form_add_pukawka->handleRequest($request);

        if ($form_add_pukawka->isSubmitted() && $form_add_pukawka->isValid()) {
            $method->setMethodName('pukawka');
            $method->setType(1);

            $entityManager->persist($method);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową metode płatności!');
            $this->logService->logAction('add', 'Dodano nową metode płatności [Pukawka - SMS]');

            return $this->redirectToRoute('admin_pm');
        }

        $form_add_hostplay = $this->createForm(pmAddType_hostplay::class, $method);
        $form_add_hostplay->handleRequest($request);

        if ($form_add_hostplay->isSubmitted() && $form_add_hostplay->isValid()) {
            $method->setMethodName('hostplay');
            $method->setType(1);

            $entityManager->persist($method);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową metode płatności!');
            $this->logService->logAction('add', 'Dodano nową metode płatności [HostPlay - SMS]');

            return $this->redirectToRoute('admin_pm');
        }

        $form_add_p24_sms = $this->createForm(pmAddType_p24sms::class, $method);
        $form_add_p24_sms->handleRequest($request);

        if ($form_add_p24_sms->isSubmitted() && $form_add_p24_sms->isValid()) {
            $method->setMethodName('przelewy24');
            $method->setType(1);

            $entityManager->persist($method);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową metode płatności!');
            $this->logService->logAction('add', 'Dodano nową metode płatności [Przelewy24 - SMS]');

            return $this->redirectToRoute('admin_pm');
        }

        $form_add_cssetti = $this->createForm(pmAddType_cssetti::class, $method);
        $form_add_cssetti->handleRequest($request);

        if ($form_add_cssetti->isSubmitted() && $form_add_cssetti->isValid()) {
            $method->setMethodName('cssetti');
            $method->setType(1);

            $entityManager->persist($method);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową metode płatności!');
            $this->logService->logAction('add', 'Dodano nową metode płatności [CSSetti - SMS]');

            return $this->redirectToRoute('admin_pm');
        }

        $form_add_gosetti = $this->createForm(pmAddType_gosetti::class, $method);
        $form_add_gosetti->handleRequest($request);

        if ($form_add_gosetti->isSubmitted() && $form_add_gosetti->isValid()) {
            $method->setMethodName('gosetti');
            $method->setType(1);

            $entityManager->persist($method);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową metode płatności!');
            $this->logService->logAction('add', 'Dodano nową metode płatności [GOSetti - SMS]');

            return $this->redirectToRoute('admin_pm');
        }

        $form_add_microsms = $this->createForm(pmAddType_microsms::class, $method);
        $form_add_microsms->handleRequest($request);

        if ($form_add_microsms->isSubmitted() && $form_add_microsms->isValid()) {
            $method->setMethodName('microsms');
            $method->setType(1);

            $entityManager->persist($method);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową metode płatności!');
            $this->logService->logAction('add', 'Dodano nową metode płatności [MicroSMS - SMS]');

            return $this->redirectToRoute('admin_pm');
        }

        $form_add_tpay = $this->createForm(pmAddType_tpay::class, $method);
        $form_add_tpay->handleRequest($request);

        if ($form_add_tpay->isSubmitted() && $form_add_tpay->isValid()) {
            $method->setMethodName('tpay');
            $method->setType(1);

            $entityManager->persist($method);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową metode płatności!');
            $this->logService->logAction('add', 'Dodano nową metode płatności [TPay - SMS]');

            return $this->redirectToRoute('admin_pm');
        }

        $form_add_liveserver = $this->createForm(pmAddType_liveserver::class, $method);
        $form_add_liveserver->handleRequest($request);

        if ($form_add_liveserver->isSubmitted() && $form_add_liveserver->isValid()) {
            $method->setMethodName('liveserver');
            $method->setType(1);

            $entityManager->persist($method);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową metode płatności!');
            $this->logService->logAction('add', 'Dodano nową metode płatności [LiveServer - SMS]');

            return $this->redirectToRoute('admin_pm');
        }

        $form_add_p24_psc = $this->createForm(pmAddType_p24psc::class, $method);
        $form_add_p24_psc->handleRequest($request);

        if ($form_add_p24_psc->isSubmitted() && $form_add_p24_psc->isValid()) {
            $method->setMethodName('przelewy24');
            $method->setType(3);

            $entityManager->persist($method);
            $entityManager->flush();

            $this->addFlash('add_success', 'Dodano nową metode płatności!');
            $this->logService->logAction('add', 'Dodano nową metode płatności [Przelewy24 - PSC]');

            return $this->redirectToRoute('admin_pm');
        }

        $form_add_p24_transfer = $this->createForm(pmAddType_p24transfer::class, $method);
        $form_add_p24_transfer->handleRequest($request);

        if ($form_add_p24_transfer->isSubmitted() && $form_add_p24_transfer->isValid()) {
            try {
                $method->setMethodName('przelewy24');
                $this->logService->logAction('add', 'Dodano nową metode płatności [Przelewy24 - Przelew]');
                $method->setType(2);

                $entityManager->persist($method);
                $entityManager->flush();

                $this->addFlash('add_success', 'Dodano nową metode płatności!');

            } catch (Exception $e) {
                $this->addFlash('add_error', 'Dodanie nowej metody nie powiodło się!');
            }

            return $this->redirectToRoute('admin_pm');
        }

        $editForm = $this->createForm(pmEditType::class, $method);

        return $this->render('admin/paymentmethods.html.twig', [
            'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
            'title' => 'Metody Płatności',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('admin')],
                ['Sklep', '#'],
                ['Zarządzanie', '#'],
                ['Metody Płatności', $this->generateUrl('admin_pm')]
            ],
            'services' => $servicesRepo->findAll(),
            'servers' => $serversRepo->findAll(),
            'pagination' => $paginator->paginate($pmRepo->findAll(), $request->query->getInt('page', 1),20),
            'form_1s1k' => $form_add_1s1k->createView(),
            'form_pukawka' => $form_add_pukawka->createView(),
            'form_hostplay' => $form_add_hostplay->createView(),
            'form_p24_sms' => $form_add_p24_sms->createView(),
            'form_cssetti' => $form_add_cssetti->createView(),
            'form_gosetti' => $form_add_gosetti->createView(),
            'form_microsms' => $form_add_microsms->createView(),
            'form_tpay' => $form_add_tpay->createView(),
            'form_liveserver' => $form_add_liveserver->createView(),
            'form_p24_psc' => $form_add_p24_psc->createView(),
            'form_p24_transfer' => $form_add_p24_transfer->createView(),
            'form_edit' => $editForm
        ]);
    }

    /**
     * @Route("/admin/payment_methods/{pm}/edit", name="edit_pm")
     * @Entity("pm", expr="repository.findById(pm)")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editAction(Request $request, PaymentMethod $pm)
    {
        $methodName = $pm->getName();

        $editForm = $this->createForm(pmEditType::class, $pm);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $this->addFlash('edit_success', 'Edytowano metodę '.$methodName.'!');
                $this->logService->logAction('edit', 'Edytowano metode płatności [#'.$methodName.']');

            } catch (\Exception $e) {
                $this->addFlash('edit_error', 'Wystąpił niespodziewany błąd.');
            }
        }

        return $this->redirectToRoute('admin_pm');
    }

    /**
     * @Route("/admin/payment_methods/delete/{id}", name="delete_method")
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteMethod(Request $request, $id)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');


        $entityManager = $this->getDoctrine()->getManager();
        $method = $this->getDoctrine()->getRepository(PaymentMethod::class)->find($id);

        if($method)
        {
            $data[0] = $method->getName();
            try {
                $entityManager->remove($method);
                $entityManager->flush();

                $data[1] = true;
                $this->logService->logAction('delete', 'Usunięto metode płatności [#'.$data[0].']');
            } catch (\Exception $e) {
                $data[1] = false;
            }
        }
        else
            $data[1] = false;

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($data);
        else
            throw new \Exception('Not allowed usage');
    }
}