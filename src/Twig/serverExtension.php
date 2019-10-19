<?php
/**
 * Created by PhpStorm.
 * User: Patryk Szczepanski
 * Date: 18/10/2019
 * Time: 09:37
 */

namespace App\Twig;

use App\Entity\Servers;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class serverExtension extends AbstractExtension
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
        $this->repository = $entityManager->getRepository(Servers::class);
    }

    public function getFilters()
    {
        return [
            new TwigFilter('server_name', [$this, 'setName']),
        ];
    }

    public function setName($price)
    {
        $price = $this->repository->find($price);

        $server = new Servers();
        return $price;
    }
}