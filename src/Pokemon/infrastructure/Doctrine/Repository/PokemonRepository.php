<?php

namespace App\Pokemon\infrastructure\Doctrine\Repository;

use App\Pokemon\domain\Entity\Pokemon;
use App\Pokemon\domain\PokemonRepositoryInterface;
use App\Pokemon\domain\Exception\PokemonNotFoundException;
use App\Pokemon\infrastructure\Doctrine\Entity\Pokemon as DoctrinePokemon;
use App\Pokemon\infrastructure\Doctrine\Entity\Ability as DoctrineAbility;
use App\Pokemon\infrastructure\Doctrine\Entity\Stat as DoctrineStat;
use App\Pokemon\infrastructure\Doctrine\Entity\Type as DoctrineType;
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

    public function save(Pokemon $pokemonEntity): void
    {
        $doctrinePokemon = new DoctrinePokemon();
        $doctrinePokemon->setName($pokemonEntity->getName());
        $doctrinePokemon->setHeight($pokemonEntity->getHeight());
        $doctrinePokemon->setWeight($pokemonEntity->getWeight());
        $doctrinePokemon->setBaseExperience($pokemonEntity->getBaseExperience());
        $doctrinePokemon->setWeight($pokemonEntity->getWeight());
        
        foreach ($pokemonEntity->getAbilities() as $abilityData) {
            $ability = new DoctrineAbility();
            $ability->setName($abilityData['name']);
            $ability->setIsHidden($abilityData['is_hidden']);
            $ability->setSlot($abilityData['slot']);
            
            $doctrinePokemon->addAbility($ability);
        }

        foreach ($pokemonEntity->getStats() as $statData) {
            $stat = new DoctrineStat();
            $stat->setName($statData['name']);
            $stat->setBaseStat($statData['base_stat']);
            $stat->setEffort($statData['effort']);

            $doctrinePokemon->addAbility($stat);
        }
        
        foreach ($pokemonEntity->getTypes() as $typeData) {
            $type = new DoctrineType();
            $type->setName($typeData['name']);
            $type->setSlot($typeData['slot']);

            $doctrinePokemon->addAbility($type);
        }

        $this->getEntityManager()->persist($doctrinePokemon);
        $this->getEntityManager()->flush();
    }

    public function delete(Pokemon $pokemonEntity): void
    {
        $doctrinePokemon = $this->findOneBy(['name' => $pokemonEntity->getName()]);

        if ($doctrinePokemon) {
            $this->getEntityManager()->remove($doctrinePokemon);
            $this->getEntityManager()->flush();
        }
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
    
    // private function setDoctrineToDomain(DoctrinePokemon $doctrinePokemon, Pokemon $pokemonEntity): Pokemon
    // {
    //     // Aquí podría asociarse mejor a un DTO?
    //     $abilities = array_map(function($ability) {
    //         return [
    //             'name' => $ability->setName($pokemonEntity->getName()),
    //             'is_hidden' => $ability->setIsHidden($pokemonEntity->isHidden()),
    //             'slot' => $ability->setSlot($pokemonEntity->getName()),
    //         ];
    //     }, $doctrinePokemon->addAbility()->toArray());

    //     $stats = array_map(function($stat) {
    //         return [
    //             'name' => $stat->setName($pokemonEntity->getName()),
    //             'base_stat' => $stat->setBaseStat($pokemonEntity->getName()),
    //             'effort' => $stat->setEffort($pokemonEntity->getName()),
    //         ];
    //     }, $doctrinePokemon->addStat()->toArray());

    //     $types = array_map(function($type) {
    //         return [
    //             'name' => $type->setName($pokemonEntity->getName()),
    //             'slot' => $type->setSlot($pokemonEntity->getName()),
    //         ];
    //     }, $doctrinePokemon->addType()->toArray());
        
    //     return new Pokemon(
    //         $doctrinePokemon->setName($pokemonEntity->getName()),
    //         $doctrinePokemon->setHeight($pokemonEntity->getName()),
    //         $doctrinePokemon->setWeight($pokemonEntity->getName()),
    //         $doctrinePokemon->setBaseExperience($pokemonEntity->getName()),
    //         $abilities,
    //         $stats,
    //         $types,
    //     );
    // }
}
