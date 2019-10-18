<?php
/**
 * Created by PhpStorm.
 * User: Dawid Pierzak
 * Date: 04.01.2019
 * Time: 01:54
 */

namespace App\Service;


class responsesService
{
    private $response = array(
        100     => 'EMPTY DATA',
        200     => 'OK',
        404     => 'NOT FOUND',
        500     => 'SERVER ERROR',
        /// SMS API CHECKING
        901     => 'CODE USED',
        902     => 'INVALID CODE',
        903     => 'EMPTY CODE',
        904     => 'CODE EXPIRED',

    );

    /**
     * Get response text value
     * @param int $id
     * @return mixed
     */
    function getResponse(int $id){
        return $this->response[$id];
    }
}