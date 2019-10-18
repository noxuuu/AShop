<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 04.01.2019
 * Time: 01:30
 */

namespace App\Service\shop\payments;

use App\Service\responsesService;

/**
 * GoSetti payment implementation
 * Class GoSettiService
 * @package App\Service\shop\payments
 */
class GoSettiService
{
    private $response;

    /**
     * oneShotOneKillService constructor.
     * @param responsesService $responsesService
     */
    public function __construct(responsesService $responsesService){
        $this->response = $responsesService;
    }

    /**
     * Check if code is valid for user
     * @param string $userId
     * @param string $code
     * @return bool|float
     */
    function checkCode(string $userId, string $code){
        if(!ctype_alnum($code)) return false;
        $response = json_decode(file_get_contents(sprintf('https://gosetti.pl/Api/SmsApiV2CheckCode.php?UserId=%d&Code=%s', $userId, $code)));
        if($response === null || $response <= 0) return false;
        return (float) $response;
    }

    /**
     * Get sms options data
     * @return mixed
     */
    function getData(){
        $data = json_decode(file_get_contents('https://gosetti.pl/Api/SmsApiV2GetData.php'));
        return $data;
    }

    /**
     * Check if sms is valid in GoSetti api
     * @param string $key
     * @param string $code
     * @param string $comment
     * @return mixed
     */
    function checkSms(string $key, string $code, string $comment){
        if($key == NULL || $key == '' || $code == NULL || $code == '') return $this->response->getResponse(100);
        $data = $this->getData();
        $amount = 0.0;
        foreach($data['Numbers'] as $number){
            if($number == $comment) $amount = $number['TopUpAmount'];
        }
        $response = $this->checkCode($key,$code);
        if($response) {
            if($response == $amount) return $this->response->getResponse(200);
            else return $this->response->getResponse(902);
        } else return $this->response->getResponse(500);
    }

}