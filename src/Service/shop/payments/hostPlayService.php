<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 04.01.2019
 * Time: 02:05
 */

namespace App\Service\shop\payments;
use App\Service\responsesService;

class hostPlayService
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
        $input = array(
            'user_id'   => $key,
            'code'      => $code,
            'comment'   => $comment
        );
        $response = json_decode(file_get_contents('https://hostplay.pl/api/payment/check-sms.json?' . http_build_query($input)));
        if(isset($response)){
            if($response === NULL && json_last_error() !== JSON_ERROR_NONE) return $this->response->getResponse(500);
            else {
                if($response->status) return $this->response->getResponse(200);
                else return $this->response->getResponse(500);
            }
        } else return $this->response->getResponse(500);

    }
}