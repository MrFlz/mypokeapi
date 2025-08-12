<?php

namespace App\Pokemon\infrastructure\services;

use App\Pokemon\infrastructure\dto\PokemonDto;
use App\Pokemon\domain\Entity\Pokemon as DomainPokemon;
use App\Pokemon\domain\Entity\Ability as DomainAbility;
use App\Pokemon\domain\Entity\Stat as DomainStat;
use App\Pokemon\domain\Entity\Type as DomainType;
use App\Pokemon\infrastructure\Doctrine\Entity\Pokemon as DoctrinePokemon;
use App\Pokemon\infrastructure\Doctrine\Entity\Ability as DoctrineAbility;
use App\Pokemon\infrastructure\Doctrine\Entity\Stat as DoctrineStat;
use App\Pokemon\infrastructure\Doctrine\Entity\Type as DoctrineType;

class PokemonMapper
{
    // Convertir de DTO a Entidad de DOMINIO
    public function toDomain(PokemonDto $dto): DomainPokemon
    {
        $abilities = array_map(function($abilityDto) {
            return new DomainAbility(
                0,
                $abilityDto->name,
                $abilityDto->is_hidden,
                $abilityDto->slot
            );
        }, $dto->abilities);
        
        $stats = array_map(function($statDto) {
            return new DomainStat(
                0,
                $statDto->name,
                $statDto->base_stat,
                $statDto->effort
            );
        }, $dto->stats);
        
        $types = array_map(function($typeDto) {
            return new DomainType(
                0,
                $typeDto->name,
                $typeDto->slot
            );
        }, $dto->types);
        
        return new DomainPokemon(
            0,
            $dto->name,
            $dto->height,
            $dto->weight,
            $dto->base_experience,
            $abilities,
            $stats,
            $types
        );
    }

    // Convertir de Entidad de DOMINIO a Entidad de DOCTRINE
    public function toDoctrineEntity(DomainPokemon $domainPokemon): DoctrinePokemon
    {
        $doctrinePokemon = new DoctrinePokemon();

        $doctrinePokemon->setName($dto->name);
        $doctrinePokemon->setHeight($dto->height);
        $doctrinePokemon->setWeight($dto->weight);
        $doctrinePokemon->setBaseExperience($dto->base_experience);

        foreach ($dto->abilities as $abilityDto) {
            $doctrineAbility = new DoctrineAbility();
            
            $doctrineAbility->setName($abilityDto->name);
            $doctrineAbility->setIsHidden($abilityDto->is_hidden);
            $doctrineAbility->setSlot($abilityDto->slot);
            
            $doctrinePokemon->addAbility($doctrineAbility);
        }

        foreach ($dto->stats as $statDto) {
            $doctrineStat = new DoctrineStat();

            $doctrineStat->setName($statDto->name);
            $doctrineStat->setBaseStat($statDto->base_stat);
            $doctrineStat->setEffort($statDto->effort);
            
            $doctrinePokemon->addStat($doctrineStat);
        }
        
        foreach ($dto->types as $typeDto) {
            $doctrineType = new DoctrineType();
            $doctrineType->setName($typeDto->name);
            $doctrineType->setSlot($typeDto->slot);
            
            $doctrinePokemon->addType($doctrineType);
        }

        return $doctrinePokemon;
    }
    
    
}