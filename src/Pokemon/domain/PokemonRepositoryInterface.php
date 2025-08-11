<?php

namespace App\Pokemon\domain;

use App\Pokemon\domain\Entity\Pokemon;
use App\Pokemon\domain\Exception\PokemonNotFoundException;

interface PokemonRepositoryInterface
{
    /**
     * Busca un Pokemon por su nombre
     *
     * @throws PokemonNotFoundException 
     */
    public function findByName(string $name): Pokemon;

    /**
     * Lista los Pokemones, limitado a 10
     *
     * @return Pokemon[]
     */
    public function list(int $limit = 10): array;
}