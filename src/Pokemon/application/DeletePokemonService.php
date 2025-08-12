<?php

namespace App\Pokemon\application;

use App\Pokemon\domain\Entity\Pokemon;
use App\Pokemon\domain\PokemonRepositoryInterface;

class DeletePokemonService
{
    public function __construct(private PokemonRepositoryInterface $pokemonRepository)
    { }

    public function execute(Pokemon $pokemon): void
    {
        $pokemon = $this->pokemonRepository->findByName($name);

        $this->pokemonRepository->delete($pokemon);
    }
}