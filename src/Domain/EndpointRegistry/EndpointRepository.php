<?php

namespace App\Domain\EndpointRegistry;

use App\Domain\EndpointManagement\Endpoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Endpoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Endpoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Endpoint[]    findAll()
 * @method Endpoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * V*/
class EndpointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Endpoint::class);
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findOneByProjectIdAndPath(string $projectId, string $path): ?Endpoint
    {
        return $this->createQueryBuilder('endpoint')
            ->andWhere('endpoint.project = :projectId')
            ->andWhere('endpoint.path = :path')
            ->setParameters([
                'projectId' => $projectId,
                'path' => $path,
            ])
            ->getQuery()
            ->getSingleResult();
    }
}
