<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 04.01.2019
 * Time: 02:57
 */

namespace App\Service\shop\payments;


use App\Service\responsesService;

class liveserverService
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
     * Check if sms is valid in liveserver api
     * @param string $key
     * @param string $code
     * @param string $comment
     * @return mixed
     */
    function checkSms(string $key, string $code, array $comment)
    {
        if ($key == NULL || $key == '' || $code == NULL || $code == '') return $this->response->getResponse(100);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://rec.liveserver.pl/api?channel=sms&return_method=seperator');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'client_id='. $key .'&pin='. urlencode($comment) .'&code='. urlencode($code) .'');
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode >= 200 && $httpcode < 300) {
            $recData = explode(' ', $data, 8);
            if(count($recData) < 8 || $recData[6] > 0) return $this->response->getResponse(902);
            else return $this->response->getResponse(200);
        }
        else return $this->response->getResponse(500);
    }


}