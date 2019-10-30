<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 19/10/2019
 * Time: 03:42
 */

namespace App\Twig;

use App\Entity\BoughtServicesLogs;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class boughtServicesExtension extends AbstractExtension
{
    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * TemporaryEmailRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(BoughtServicesLogs::class);
    }

    /**
     * @return array|TwigFilter[]|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('bs_countEm', [$this, 'returnCount']),
            new TwigFilter('getRandomRGB', [$this, 'getRandomRGB']),
        ];
    }


    /**
     * @param $number
     * @return string
     */
    public function GetRgbColorByNumber($number)
    {
        if($number < 0) $number = 0;
        switch($number)
        {
            case 0: return '60,184,120';//zielony
            case 1: return '241,91,38'; // pomarańczowy
            case 2: return '252,176,59'; // pod czerwony
            case 3: return '86,111,201'; // niebieski
            default: return $this->GetRgbColorByNumber($number-4);
        }
    }
    /**
     * @param $service
     * @return mixed
     */
    public function returnCount($service)
    {
        return $this->repository->countEmDistinct($service);
    }

    /**
     * @param $number
     * @return string
     */
    public function getRandomRGB($number)
    {
        return $this->GetRgbColorByNumber($number);
    }
}