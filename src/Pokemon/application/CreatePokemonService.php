<?php

namespace App\Pokemon\application;

use App\Pokemon\domain\Entity\Pokemon;
use App\Pokemon\domain\PokemonRepositoryInterface;

class CreatePokemonService
{
    public function __construct(private PokemonRepositoryInterface $pokemonRepository)
    { }

    public function execute(Pokemon $pokemon): void
    {
        $this->pokemonRepository->save($pokemon);
    }
}