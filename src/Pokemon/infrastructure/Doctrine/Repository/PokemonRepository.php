<?php

namespace App\Pokemon\infrastructure\Doctrine\Repository;

use App\Pokemon\domain\Entity\Pokemon;
use App\Pokemon\domain\PokemonRepositoryInterface;
use App\Pokemon\domain\Exception\PokemonNotFoundException;
use App\Pokemon\infrastructure\Doctrine\Entity\Pokemon as DoctrinePokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pokemon>
 */
class PokemonRepository extends ServiceEntityRepository implements PokemonRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrinePokemon::class);
    }

    public function findByName(string $name): Pokemon
    {
        $doctrinePokemon = $this->findOneBy(['name' => $name]);
        if (!$doctrinePokemon) {
            throw new PokemonNotFoundException($name);
        }
        return $this->convertDoctrineToDomain($doctrinePokemon);
    }

    public function list(int $limit = 10): array
    {
        $doctrinePokemons = $this->createQueryBuilder('p')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return array_map(
            fn(DoctrinePokemon $p) => $this->convertDoctrineToDomain($p),
            $doctrinePokemons
        );
    }

    private function convertDoctrineToDomain(DoctrinePokemon $doctrinePokemon): Pokemon
    {
        // Aquí podría asociarse mejor a un DTO?
        $abilities = array_map(function($ability) {
            return [
                'name' => $ability->getName(),
                'is_hidden' => $ability->isHidden(),
                'slot' => $ability->getSlot(),
            ];
        }, $doctrinePokemon->getAbilities()->toArray());

        $stats = array_map(function($stat) {
            return [
                'name' => $stat->getName(),
                'base_stat' => $stat->getBaseStat(),
                'effort' => $stat->getEffort(),
            ];
        }, $doctrinePokemon->getStats()->toArray());

        $types = array_map(function($type) {
            return [
                'name' => $type->getName(),
                'slot' => $type->getSlot(),
            ];
        }, $doctrinePokemon->getTypes()->toArray());
        
        return new Pokemon(
            $doctrinePokemon->getId(),
            $doctrinePokemon->getName(),
            $doctrinePokemon->getHeight(),
            $doctrinePokemon->getWeight(),
            $doctrinePokemon->getBaseExperience(),
            $abilities,
            $stats,
            $types,
        );
    }
}
