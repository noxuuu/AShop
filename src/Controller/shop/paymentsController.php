<?php

namespace App\Controller\shop;

use App\Entity\PaymentMethod;
use App\Entity\Prices;
use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\UserServices;

use App\Entity\Tariffs;
use App\Entity\TemporaryPayments;
use App\Service\shop\payments\csSetiService;
use App\Service\shop\payments\GoSettiService;
use App\Service\shop\payments\hostPlayService;
use App\Service\shop\payments\liveserverService;
use App\Service\shop\payments\microSmsService;
use App\Service\shop\payments\oneShotOneKillService;
use App\Service\shop\payments\paymentType;
use App\Service\shop\payments\przelewy24Service;
use App\Service\shop\payments\pukawkaService;
use App\Service\shop\payments\tPayService;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Default route for payments
 *
 * Class paymentsController
 * @package App\Controller
 */
class paymentsController extends AbstractController
{
    // payments
    private $csSeti;
    private $goSetti;
    private $hostPlay;
    private $microSms;
    private $oneShotOneKill;
    private $pukawka;
    private $przelewy24;
    private $tPay;
    private $liveserver;

    // payment type
    private $paymentType;

    public function __construct(
        csSetiService $csSetiService,
        GoSettiService $goSettiService,
        hostPlayService $hostPlayService,
        microSmsService $microSmsService,
        oneShotOneKillService $oneShotOneKillService,
        przelewy24Service $przelewy24Service,
        pukawkaService $pukawkaService,
        tPayService $tPayService,
        liveserverService $liveserver,
        paymentType $paymentType)
    {
        $this->csSeti = $csSetiService;
        $this->goSetti = $goSettiService;
        $this->hostPlay = $hostPlayService;
        $this->microSms = $microSmsService;
        $this->oneShotOneKill = $oneShotOneKillService;
        $this->przelewy24 = $przelewy24Service;
        $this->pukawka = $pukawkaService;
        $this->tPay = $tPayService;
        $this->liveserver = $liveserver;
        $this->paymentType = $paymentType;
    }

    /**
     * get payments list
     * @Route("/list", name="paymentList")
     * @return array
     */
    public function paymentList()
    {
        return [];
    }

    /**
     * get payments via type
     * @Route("/sms/{type}", name="paymentType")
     * @param string $type
     * @return csSetiService|GoSettiService|hostPlayService|microSmsService|oneShotOneKillService|przelewy24Service|pukawkaService
     */
    public function getPaymentAccess(string $type)
    {
        if ($type == 'cssetti') $pay = $this->csSeti;
        else if ($type == 'gosetti') $pay = $this->goSetti;
        else if ($type == 'hostplay') $pay = $this->hostPlay;
        else if ($type == 'microsms') $pay = $this->microSms;
        else if ($type == 'oneshotonekill') $pay = $this->oneShotOneKill;
        else if ($type == 'przelewy24') $pay = $this->przelewy24;
        else if ($type == 'pukawka') $pay = $this->pukawka;
        else if ($type == 'tpay') $pay = $this->tPay;
        else if ($type == 'liveserver') $pay = $this->liveserver;
        else $pay = false;
        return $pay;
    }

    /**
     * Register a payment and return paymentHash
     * @param Services $service
     * @param Servers $server
     * @param string $auth_data
     * @param string $amount
     * @param $date
     * @return bool|string
     */
    public function registerPayment(Services $service, Servers $server, string $auth_data, string $amount, $date)
    {
        $time = new \DateTime();
        $hash = substr(md5($time->format('H:i:s \O\n Y-m-d')), 0, 8);
        $entityManager = $this->getDoctrine()->getManager();

        $tmpPayment = new TemporaryPayments();
        $tmpPayment->setPaymentHash($hash);
        $tmpPayment->setServiceId($service->getId());
        $tmpPayment->setServerId($server->getId());
        $tmpPayment->setAuthData($auth_data);
        $tmpPayment->setAmount($amount);
        $tmpPayment->setDate($date);

        $entityManager->persist($tmpPayment);
        $entityManager->flush();

        return $hash;
    }

    /**
     * Returns values for given data
     * @Route("/buy/{service}/{server}/{payment}/")
     */
    public function loadValues(Request $request, $service, $server, $payment)
    {
        // get repo's
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $pricesRepo = $this->getDoctrine()->getRepository(Prices::class);

        // if there is no service or server with this names or wrong payment type - throw exception
        if (!$servicesRepo->findOneBy(['name' => $service])
            || !$serversRepo->findOneBy(['name' => $server])
            || !($payment == 'sms' || $payment == 'paysafecard' || $payment == 'transfer'))
            throw $this->createNotFoundException('Bad credentials');

        // Get prices for specified payment types
        $prices = $pricesRepo->GetValuesFor($servicesRepo->findOneBy(['name' => $service])->GetId(), $this->paymentType->getPaymentTypeId($payment));

        // Send data
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($prices);
        else
            throw new \Exception('Not allowed usage');
    }


    /**
     * Returns price info for given data
     * @Route("/buy/{service}/{server}/{payment}/{value}/")
     */
    public function loadPriceInfo(Request $request, $service, $server, $payment, $value)
    {
        // get repo's
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $pricesRepo = $this->getDoctrine()->getRepository(Prices::class);

        // if there is no service or server with this names or wrong payment type - throw exception
        if (!$servicesRepo->findOneBy(['name' => $service])
            || !$serversRepo->findOneBy(['name' => $server])
            || !($payment == 'sms' || $payment == 'paysafecard' || $payment == 'transfer' || $payment == 'paypal')
            || $value <= 0)
            throw $this->createNotFoundException('Bad credentials');

        // Get price info
        $price = $pricesRepo->GetPriceInfo($servicesRepo->findOneBy(['name' => $service])->GetId(), $this->paymentType->getPaymentTypeId($payment), $value);

        // Send data
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($price);
        else
            throw new \Exception('Not allowed usage');
    }

    /**
     * Validate payment centre *
     * @Route("/payment/perform/{type}/{service}/{server}/{value}/{authData}/{code}/")
     * @param Request $request
     * @param $type (sms|paysafecard|transfer|paypal)
     * @param $service
     * @param $server
     * @param $value
     * @param $authData
     * @param $code
     * @return JsonResponse
     * @throws \Exception
     */
    public function performPayment(Request $request, $type, $service, $server, $value, $authData, $code)
    {
        $ajaxResponse = array();

        // get repo's
        $tempServicesRepo = $this->getDoctrine()->getRepository(UserServices::class);
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $paymentRepo = $this->getDoctrine()->getRepository(PaymentMethod::class);
        $tariffsRepo = $this->getDoctrine()->getRepository(Tariffs::class);
        $pricesRepo = $this->getDoctrine()->getRepository(Prices::class);

        if ($this->paymentType->getPaymentTypeId($type) == -1
            || ($type == 'sms' && empty($code))
            || !$servicesRepo->findOneBy(['name' => $service])
            || !($server = $serversRepo->findOneBy(['name' => $server]))
            || $value < 1) {
            throw $this->createNotFoundException('Bad credentials');
        } else {
            // Get price info
            if ($price = $pricesRepo->GetPriceInfo($servicesRepo->findOneBy(['name' => $service])->GetId(), $this->paymentType->getPaymentTypeId($type), $value)) {
                // get tariff
                $tariff = $tariffsRepo->findOneBy(['id' => $price[0]['tariffId']]);

                // initialize payment
                switch ($type) {
                    case 'sms':
                        {
                            // get payment info
                            $paymentInfo = $paymentRepo->findOneBy(['id' => $price[0]['paymentId']]);

                            // validate SMS info
                            $paymentHandler = $this->getPaymentAccess($paymentInfo->getMethodName());
                            $response = $paymentHandler->checkSms($paymentInfo->getApikey(), $paymentInfo->getApisecret(), $paymentInfo->getServiceId(), $code, $tariff->getSmsNumber(), $tariff->getBrutto() * 100);

                            // add service when response is OK (200)
                            if ($response == "OK") {
                                // log payment
                                $serviceAdded2 = $tempServicesRepo->addService();

                                // give client's service
                                $serviceAdded = $tempServicesRepo->addService($price[0]['priceId'], $server, $authData);

                                // print info or throw error when service isn't inserted..
                                if ($serviceAdded) {
                                    $ajaxResponse[0]['type'] = 'success';
                                    $ajaxResponse[0]['response'] = 'Kod prawidłowy, usługa została dodana!';
                                }
                                else
                                {
                                    $ajaxResponse[0]['type'] = 'error';
                                    $ajaxResponse[0]['holdTime'] = 0; // hold this message permamently..
                                    $ajaxResponse[0]['response'] = 'Kod jest prawidłowy, lecz nie byliśmy w stanie dodać Twojej usługi.. Skontaktuj się z administratorem..';
                                }
                            } else {
                                $ajaxResponse[0]['type'] = 'error';
                                $ajaxResponse[0]['response'] = 'Podany kod jest nieprawidłowy!';
                            }
                        }
                    case 'transfer':
                        {

                        }
                    case 'paysafecard':
                        {

                        }
                    case 'paypal':
                        {

                        }
                }
            }
        }

        // Send data
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($ajaxResponse);
        else
            throw new \Exception('Not allowed usage');
    }

    // - pierwsze skonczyc i poprawic system walidacji sms, aby nie przekazywac danych przez komentarze (dodac apisecret, apikey, number)
}