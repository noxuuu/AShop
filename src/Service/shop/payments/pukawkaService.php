<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 04.01.2019
 * Time: 02:10
 */

namespace App\Service\shop\payments;


use App\Service\responsesService;

class pukawkaService
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
     * Check if sms is valid in hostPlay api
     * @param string $key
     * @param string $code
     * @param string $comment
     * @return mixed
     */
    function checkSms(string $key, string $code, string $comment){
        if($key == NULL || $key == '' || $code == NULL || $code == '') return $this->response->getResponse(100);
        $response = json_decode(file_get_contents(sprintf('https://admin.pukawka.pl/api/?keyapi=%d&type=sms&code=%d', $key, $code)));
        if(is_object($response)){
            if($response->status == 'ok') return $this->response->getResponse(200);
            else return $this->response->getResponse(902);
        } else $this->response->getResponse(500);

    }

}