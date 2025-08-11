<?php

namespace App\Pokemon\application;

use App\Pokemon\domain\PokemonRepositoryInterface;

class ListPokemonsService
{
    public function __construct(private PokemonRepositoryInterface $pokemonRepository)
    { }

    public function execute(int $limit = 10): array
    {
        $pokemons = $this->pokemonRepository->list($limit);
        
        return array_map(fn($pokemon) => $pokemon->toArray(), $pokemons);
    }
}