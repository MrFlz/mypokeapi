<?php

namespace App\Pokemon\application;

use App\Pokemon\domain\PokemonRepositoryInterface;

class ListPokemonsService
{
    //private PokemonRepositoryInterface $pokemonRepository;

    public function __construct(private PokemonRepositoryInterface $pokemonRepository)
    {
        // $this->pokemonRepository = $pokemonRepository;
    }

    public function execute(int $limit = 10): array
    {
        $pokemons = $this->pokemonRepository->list($limit);
        
        return array_map(fn($pokemon) => $pokemon->toArray(), $pokemons);
    }
}