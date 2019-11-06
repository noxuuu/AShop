<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 04/11/2019
 * Time: 11:35
 */

namespace App\Controller\shop;


use App\Entity\PaymentMethod;
use App\Entity\Prices;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Tariffs;
use App\Entity\UserServices;
use App\Service\shop\payments\oneShotOneKillService;
use App\Service\shop\payments\paymentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class userController extends AbstractController
{
    // payments
    private $oneShotOneKill;

    // payment type
    private $paymentType;

    public function __construct(
        oneShotOneKillService $oneShotOneKillService,
        paymentType $paymentType)
    {
        $this->oneShotOneKill = $oneShotOneKillService;
        $this->paymentType = $paymentType;
    }

    /** get payments via type
     * @param string $type
     * @return oneShotOneKillService
     */
    public function getPaymentAccess(string $type)
    {
        if ($type == 'oneshotonekill') $pay = $this->oneShotOneKill;
        else $pay = false;
        return $pay;
    }

    /**
     * Get common of user services
     *
     * @Route("/user/my-services", name="user_services")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function userServices()
    {
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $uServicesRepo = $this->getDoctrine()->getRepository(UserServices::class);

        $services = $servicesRepo->findAll();
        $servers = $serversRepo->findAll();
        $user_services = $uServicesRepo->findBy(['authData' => $this->getUser()->getAuthData()]);
        $breadcrumbs = [];

        return $this->render('frontend/pages/user/services.html.twig', [
            'services' => $services,
            'servers' => $servers,
            'user_services' => $user_services,
            'title' => 'Twoje usługi',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Returns values for given data
     * @Route("/api/get/accessible-payment-types")
     */
    public function loadPayments(Request $request)
    {
        // get repo
        $pricesRepo = $this->getDoctrine()->getRepository(Prices::class);

        // Get prices for specified payment types
        $data = $pricesRepo->GetAccesiblePaymentTypes();

        // Send data
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($data);
        else
            throw new \Exception('Not allowed usage');
    }

    /**
     * Returns values for given data
     * @Route("/api/get/tariff-values/{method}")
     */
    public function loadValuesSMS(Request $request, $method)
    {
        // get repo
        $tariffsRepo = $this->getDoctrine()->getRepository(Tariffs::class);

        // Get prices for specified payment types
        $data = $tariffsRepo->GetPaymentTypeValues($method);

        // Send data
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($data);
        else
            throw new \Exception('Not allowed usage');
    }

    /**
     * Returns tariff info
     * @Route("/api/get/tariff-info/{id}")
     */
    public function loadTariffInfo(Request $request, $id)
    {
        // get repo
        $tariffsRepo = $this->getDoctrine()->getRepository(Tariffs::class);

        // Get prices for specified payment types
        $data = $tariffsRepo->getTariffInfo($id);

        // Send data
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($data);
        else
            throw new \Exception('Not allowed usage');
    }

    /**
     * Returns tariff info
     * @Route("/api/payment/sms/perform/{tariff}/{smsCode}")
     */
    public function performPaymentSMS(Request $request, $tariff, $smsCode)
    {
        // perform array
        $ajaxResponse = array();

        // get repo
        $tariffsRepo = $this->getDoctrine()->getRepository(Tariffs::class);
        $paymentRepo = $this->getDoctrine()->getRepository(PaymentMethod::class);

        // Get prices for specified payment types
        $tariff = $tariffsRepo->find($tariff);

        if($tariff)
        {
            // get payment info
            $paymentInfo = $tariff->getPaymentMethodId();

            // validate SMS info
            $paymentHandler = $this->getPaymentAccess($paymentInfo->getMethodName());
            $response = $paymentHandler->checkSms($paymentInfo->getApikey(), $paymentInfo->getApisecret(), $paymentInfo->getServiceId(), $smsCode, $tariff->getSmsNumber(), $tariff->getBrutto() * 100);

            // add service when response is OK (200)
            if ($response == "OK") {

                $filled = false;

                // add funds to wallet
                $user = $this->getUser();
                $user->setWallet($user->getWallet() + $tariff->getNetto());

                try {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $filled = true;
                } catch (\Exception $e) {
                    $filled = false;
                }

                // print info or throw error when service isn't inserted..
                if ($filled) {
                    $ajaxResponse[0]['type'] = 'success';
                    $ajaxResponse[0]['amount'] = $tariff->getNetto();
                    $ajaxResponse[0]['response'] = 'Portfel został doładowany kwotą '.$tariff->getNetto().' zł!';
                }
                else
                {
                    $ajaxResponse[0]['type'] = 'error';
                    $ajaxResponse[0]['response'] = 'Kod jest prawidłowy, lecz nie byliśmy w stanie doładować Twojego portfela.. Skontaktuj się z administratorem..';
                }
            } else {
                $ajaxResponse[0]['type'] = 'error';
                $ajaxResponse[0]['response'] = 'Podany kod jest nieprawidłowy!';
            }

            // Send data
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
                return new JsonResponse($ajaxResponse);
            else
                throw new \Exception('Not allowed usage');
        }
        throw new \Exception('Not allowed usage');
    }
}