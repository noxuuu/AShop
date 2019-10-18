<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 09/01/2019
 * Time: 10:53
 */

namespace App\Service\shop\payments;


class paymentType
{
    /**
     * @param $name
     * @return int
     */
    function getPaymentTypeId($name)
    {
        switch($name)
        {
            case 'sms': return 1;
            case 'transfer': return 2;
            case 'paysafecard': return 3;
            case 'paypal': return 4;
            default: -1;
        }
    }
}