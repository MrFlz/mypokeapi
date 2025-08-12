<?php

namespace App\Pokemon\application;

use App\Pokemon\domain\Entity\Pokemon;
use App\Pokemon\domain\PokemonRepositoryInterface;

class UpdatePokemonService
{
    public function __construct(private PokemonRepositoryInterface $pokemonRepository)
    { }

    public function execute(string $name, array $newData): Pokemon
    {
        $pokemon = $this->pokemonRepository->findByName($name);
        
        $pokemon->setName($newData['name'] ?? $pokemon->getName());
        $pokemon->setHeight($newData['height'] ?? $pokemon->getHeight());
        $pokemon->setWeight($newData['weight'] ?? $pokemon->getWeight());
        $pokemon->setBaseExperience($newData['base_experience'] ?? $pokemon->getBaseExperience());
        $pokemon->addAbilities($newData['abilities'] ?? $pokemon->getAbilities());
        $pokemon->addStats($newData['stats'] ?? $pokemon->getStats());
        $pokemon->addTypes($newData['types'] ?? $pokemon->getTypes());

        $this->pokemonRepository->save($pokemon);
        
        return $pokemon;
    }
}