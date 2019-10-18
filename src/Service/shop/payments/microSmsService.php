<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 04.01.2019
 * Time: 02:45
 */

namespace App\Service\shop\payments;


use App\Service\responsesService;

class microSmsService
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
     * https://microsms.pl/partner/documents/
     * @param string $key
     * @param string $code
     * @param string $comment
     * @return mixed
     */
    function checkSms(string $key, string $code, array $comment)
    {
        if ($key == NULL || $key == '' || $code == NULL || $code == '') return $this->response->getResponse(100);
        $response = json_decode(file_get_contents(sprintf('http://microsms.pl/api/v2/index.php?userid=%d&number=%d&code=%d&serviceid=%d', $key, $comment[0], $code, $comment[1])));
        if(is_object($response)){
            if($response->status == 'OK') return $this->response->getResponse(200);
            else return $this->response->getResponse(902);
        } else return $this->response->getResponse(500);
    }

}