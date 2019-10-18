<?php

namespace App\Service\shop\payments;

use App\Service\responsesService;

define("P24_VERSION", "3.2");

class przelewy24Service
{
   private $hostLive = "https://secure.przelewy24.pl/";
   private $hostSandbox = "https://sandbox.przelewy24.pl/";
   private $testMode = false;
   private $merchantId = 0;
   private $posId = 0;
   private $salt = "";
   private $postData = array();
   private $response;

   /**
    *
    * Obcject constructor. Set initial parameters
    * @param int $merchantId
    * @param int $posId
    * @param string $salt
    * @param bool $testMode
    */
   public function __construct(int $merchantId = NULL, int $posId = NULL, string $salt = NULL, $testMode = false, responsesService $responsesService)
   {

       $this->merchantId = (int)$merchantId;
       $this->posId = (int)$posId;
       $this->salt = $salt;
       $this->response = $responsesService;

       if ($this->merchantId === 0)
           $this->merchantId = $this->posId;

       if ($testMode) {
           $this->hostLive = $this->hostSandbox;
       }

       $this->addValue("p24_merchant_id", $merchantId);
       $this->addValue("p24_pos_id", $this->posId);
       $this->addValue("p24_api_version", P24_VERSION);

       return true;
   }

   /**
    *
    * Returns host URL
    */
   public function getHost()
   {
       return $this->hostLive;
   }

   /**
    *
    * Add value do post request
    * @param string $name Argument name
    * @param mixed $value Argument value
    * @todo Add postData validation
    */
   public function addValue($name, $value)
   {
       $this->postData[$name] = $value;
   }

   /**
    *
    * Function is testing a connection with P24 server
    * @return array Array(INT Error, Array Data), where data
    */
   public function testConnection()    {
       $crc = md5($this->posId . "|" . $this->salt);
       $ARG["p24_merchant_id"] = $this->merchantId;
       $ARG["p24_pos_id"] = $this->posId;
       $ARG["p24_sign"] = $crc;
       $RES = $this->callUrl("testConnection", $ARG);
       return $RES;
   }

   /**
    *
    * Prepare a transaction request
    * @param bool $redirect Set true to redirect to Przelewy24 after transaction registration
    * @return array array(INT Error code, STRING Token)
    */
   public function trnRegister($redirect = false)    {

       $crc = md5($this->postData["p24_session_id"] . "|" . $this->posId . "|" . $this->postData["p24_amount"] . "|" . $this->postData["p24_currency"] . "|" . $this->salt);
       $this->addValue("p24_sign", $crc);
       $RES = $this->callUrl("trnRegister", $this->postData);
       if ($RES["error"] == "0") {
           $token = $RES["token"];
       } else {
           return $RES;
       }
       if ($redirect) {
           $this->trnRequest($token);

       }
       return array("error" => 0, "token" => $token);
   }

   /**
    * Redirects or returns URL to a P24 payment screen
    * @param string $token Token
    * @param bool $redirect If set to true redirects to P24 payment screen. If set to false function returns URL to redirect to P24 payment screen
    * @return string URL to P24 payment screen
    */
   public function trnRequest($token, $redirect = true)
   {
       if ($redirect) {
           header("Location:" . $this->hostLive . "trnRequest/" . $token);
           return "";
       } else {
           return $this->hostLive . "trnRequest/" . $token;
       }
   }

   /**
    *
    * Function verify received from P24 system transaction's result.
    * @return array
    */
   public function trnVerify()
   {
       $crc = md5($this->postData["p24_session_id"] . "|" . $this->postData["p24_order_id"] . "|" . $this->postData["p24_amount"] . "|" . $this->postData["p24_currency"] . "|" . $this->salt);
       $this->addValue("p24_sign", $crc);
       $RES = $this->callUrl("trnVerify", $this->postData);
       return $RES;
   }

   /**
    *
    * Function contect to P24 system
    * @param string $function Method name
    * @param array $ARG POST parameters
    * @return array array(INT Error code, ARRAY Result)
    */
   private function callUrl($function, $ARG)
   {
       if (!in_array($function, array("trnRegister", "trnRequest", "trnVerify", "testConnection"))) {
           return array("error" => 201, "errorMessage" => "class:Method not exists");
       }
       $REQ = array();
       foreach ($ARG as $k => $v) $REQ[] = $k . "=" . urlencode($v);

       $url = $this->hostLive . $function;
       $user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
       if ($ch = curl_init()) {
           if (count($REQ)) {
               curl_setopt($ch, CURLOPT_POST, 1);
               curl_setopt($ch, CURLOPT_POSTFIELDS, join("&", $REQ));
           }
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
           curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
           if ($result = curl_exec($ch)) {
               $INFO = curl_getinfo($ch);
               curl_close($ch);
               if ($INFO["http_code"] != 200) {
                   return array("error" => 200, "errorMessage" => "call:Page load error (" . $INFO["http_code"] . ")");
               } else {
                   $RES = array();
                   $X = explode("&", $result);
                   foreach ($X as $val) {
                       $Y = explode("=", $val);
                       $RES[trim($Y[0])] = urldecode(trim($Y[1]));
                   }
                   if (!isset($RES["error"])) return array("error" => 999, "errorMessage" => "call:Unknown error");
                   return $RES;
               }
           } else {
               curl_close($ch);
               return array("error" => 203, "errorMessage" => "call:Curl exec error");
           }
       } else {
           return array("error" => 202, "errorMessage" => "call:Curl init error");
       }
   }

    /**
     * @param string $apikey
     * @param string $apisecret
     * @param int $serviceid
     * @param string $code
     * @param int $number
     * @param int $amount PLN*100
     * @return mixed
     */
   function checkSms(string $apikey, string $apisecret, int $serviceid, string $code, int $number, int $amount){
       if($serviceid == NULL || !$serviceid || $code == NULL || $code == '')
           return $this->response->getResponse(100);

       $user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
       $P = array();
       $P[] = "p24_id_sprzedawcy=".$serviceid;
       $P[] = "p24_kwota=".$amount;
       $P[] = "p24_sms=".$code;

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_POST,1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,join("&",$P));
       curl_setopt($ch, CURLOPT_URL, "https://secure.przelewy24.pl/smsver.php");
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
       curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       $result = curl_exec ($ch);

       if ($result == "OK") return $this->response->getResponse(200);
       else if($result == "ERROR 04") return $this->response->getResponse(902);
       else if($result == "ERROR 102") return $this->response->getResponse(904);
       else return $this->response->getResponse(500);
   }



}