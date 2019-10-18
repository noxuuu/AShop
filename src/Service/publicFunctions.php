<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 15:00
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;


class publicFunctions
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    function getSiteUrl()
    {
        return $this->requestStack->getCurrentRequest()->getBaseUrl();
    }

    function getSettingsNames()
    {
        return [
            'shop_title',
            'shop_address',
            'shop_commands',
            'payment_url_livetime',
            'allow_psc_payment',
            'debug',
            'steam_bot_login',
            'steam_bot_password',
            'allow_steam_bot_info',
            'stats_target_income',
            'stats_target_sold_services',
            'stats_target_send_sms'
        ];
    }
}