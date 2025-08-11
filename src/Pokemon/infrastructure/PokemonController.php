<?php

namespace App\Pokemon\infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Pokemon\application\ListPokemonsService;
use App\Pokemon\application\FindPokemonService;
use App\Pokemon\domain\PokemonNotFoundException;

class PokemonController extends AbstractController
{

    public function __construct(
        private ListPokemonsService $listPokemonsService,
        private FindPokemonService $findPokemonService
    ) { }

    public function listPokemons(): JsonResponse
    {
        $pokemonsData = $this->listPokemonsService->execute(10);

        return $this->json([
            'status' => 'OK',
            'total' => count($pokemonsData),
            'pokemon' => $pokemonsData,
        ]);
    }

    public function findPokemon(string $name): JsonResponse
    {
        try {
            $pokemonData = $this->findPokemonService->execute($name);

            return $this->json([
                'status' => 'OK',
                'pokemon' => $pokemonData,
            ]);
        } catch (PokemonNotFoundException $e) {
            return $this->json([
                'status' => 'ERROR',
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
    }
}