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

    // todo function daysToSeconds();
}