<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 19/10/2019
 * Time: 03:42
 */

namespace App\Twig;

use App\Service\steamAuthService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class steamAuthExtension extends AbstractExtension
{
    /**
     * @var steamAuthService
     */
    private $steamAuth;

    public function __construct(steamAuthService $steamAuth)
    {
        $this->steamAuth = $steamAuth;
    }

    /**
     * @return array|TwigFilter[]|\Twig_Filter[]
     */
    public function getFilters()
    {

        return [
            new TwigFilter('toCommunityId', [$this, 'toCommunityId']),
            new TwigFilter('getSteamAvatar', [$this, 'getAvatar']),
        ];
    }

    /**
     * @param $authData
     * @return string
     */
    public function toCommunityId($authData)
    {
        return $this->steamAuth->toCommunityID($authData);
    }

    /**
     * @param $authData
     * @return string
     */
    public function getAvatar($authData)
    {
        return $this->steamAuth->getAvatar($this->steamAuth->toCommunityID($authData));
    }
}















