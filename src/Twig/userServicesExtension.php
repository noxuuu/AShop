<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 19/10/2019
 * Time: 03:42
 */

namespace App\Twig;

use App\Entity\UserServices;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class userServicesExtension extends AbstractExtension
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
        $this->repository = $entityManager->getRepository(UserServices::class);
    }

    /**
     * @return array|TwigFilter[]|\Twig_Filter[]
     */
    public function getFilters()
    {

        return [
            new TwigFilter('get_service_progressbar', [$this, 'getProgress'], array('is_safe' => array('html'))),
        ];
    }


    /**
     * @param $service
     * @return string
     */
    public function getProgress($service)
    {
        $date = new \DateTime();
        $current_timestamp = $date->getTimestamp();
        $bought_timestamp = $service->getBoughtDate()->getTimestamp();
        $expires_timestamp = $service->getExpires()->getTimestamp();

        $percent = round(100 - ( ($current_timestamp - $bought_timestamp) /($expires_timestamp - $bought_timestamp) ) * 100);

        if($percent >= 60) $style = 'success';
        else if($percent >= 25) $style = 'warning';
        else $style = 'danger';


        return '<div class="progress-bar progress-bar-'.$style.'" style="width: '.$percent.'%"></div>';
    }
}















