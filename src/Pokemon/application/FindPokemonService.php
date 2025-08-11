<?php

namespace App\Pokemon\application;

use App\Pokemon\domain\PokemonRepositoryInterface;
use App\Pokemon\domain\Exception\PokemonNotFoundException;

class FindPokemonService
{
    //private PokemonRepositoryInterface $pokemonRepository;

    public function __construct(private PokemonRepositoryInterface $pokemonRepository)
    {
        //$this->pokemonRepository = $pokemonRepository;
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