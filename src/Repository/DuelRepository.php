<?php

namespace App\Repository;

use App\Entity\Duel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DuelRepository extends ServiceEntityRepository
{
    /**
     * DuelRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Duel::class);
    }
}
