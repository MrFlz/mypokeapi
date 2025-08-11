<?php

namespace App\Pokemon\application;

use App\Pokemon\domain\PokemonRepositoryInterface;
use App\Pokemon\domain\PokemonNotFoundException;

class FindPokemonService
{
    private PokemonRepositoryInterface $pokemonRepository;

    public function __construct(PokemonRepositoryInterface $pokemonRepository)
    {
        $this->pokemonRepository = $pokemonRepository;
    }

    /**
     * @throws PokemonNotFoundException
     */
    public function execute(string $name): array
    {
        $pokemon = $this->pokemonRepository->findByName($name);
        
        return $pokemon->toArray();
    }
}