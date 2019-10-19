<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 19/10/2019
 * Time: 03:42
 */

namespace App\Twig;

use App\Entity\Services;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class serviceExtension extends AbstractExtension
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
        $this->repository = $entityManager->getRepository(Services::class);
    }

    /**
     * @return array|TwigFilter[]|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('get_service', [$this, 'returnObject']),
        ];
    }


    /**
     * @param $service
     * @return null|object
     */
    public function returnObject($service)
    {
        $service = $this->repository->find($service);
        return $service;
    }
}