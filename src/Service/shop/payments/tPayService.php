<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 04.01.2019
 * Time: 02:42
 */

namespace App\Service\shop\payments;


use App\Service\responsesService;

class tPayService
{
    private $response;

    /**
     * constructor.
     * @param responsesService $responsesService
     */
    public function __construct(responsesService $responsesService){
        $this->response = $responsesService;
    }

    /**
     * Check if sms is valid in tPay api
     * @param string $key
     * @param string $code
     * @param string $comment
     * @return mixed
     */
    function checkSms(string $key, string $code, string $comment)
    {
        if ($key == NULL || $key == '' || $code == NULL || $code == '') return $this->response->getResponse(100);
        $postfields = array();
        $postfields['tfCodeToCheck'] = $key;
        $postfields['tfHash'] = $code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms.transferuj.pl/widget/verifyCode.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = explode("\n", $response);
        $status = $data[0];
        $lifetime = rtrim($data[1]);
        if ($status == 0) return $this->response->getResponse(200);
        else return $this->response->getResponse(500);
    }

}