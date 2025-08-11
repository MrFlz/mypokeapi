<?php

namespace App\Pokemon\infrastructure\Doctrine\Repository;

use App\Pokemon\domain\Entity\Pokemon;
use App\Pokemon\domain\PokemonRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pokemon>
 */
class PokemonRepository extends ServiceEntityRepository implements PokemonRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    public function findByName(string $name): ?Pokemon
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function list(int $limit = 10): array
    {
        return $this->findAll();
    }
}
