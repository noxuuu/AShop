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
            new TwigFilter('get_service_progressbar', [$this, 'getProgress']),
        ];
    }


    /**
     * @param $service
     * @return null|object
     */
    public function getProgress($service)
    {
        //$service = $this->repository->find($service);
        return $service->getBoughtDate()->format('Y-m-d H:i:s');
    }
}