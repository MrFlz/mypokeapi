<?php

namespace App\Pokemon\infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

use App\Pokemon\application\ListPokemonsService;
use App\Pokemon\application\FindPokemonService;
use App\Pokemon\application\CreatePokemonService;
use App\Pokemon\application\UpdatePokemonService;
use App\Pokemon\application\DeletePokemonService;
use App\Pokemon\infrastructure\dto\PokemonDto;
use App\Pokemon\infrastructure\services\PokemonMapper;

class PokemonController extends AbstractController
{

    public function __construct(
        private ListPokemonsService $listPokemonsService,
        private FindPokemonService $findPokemonService,
        private CreatePokemonService $createPokemonService,
        private UpdatePokemonService  $updatePokemonService,
        private DeletePokemonService $deletePokemonService,
        private ValidatorInterface $validator,
        private PokemonMapper $pokemonMapper,
        private SerializerInterface $serializer,
    ) { }

    public function createPokemon(Request $request): JsonResponse
    {
        try {
            $pokemonDto = $this->serializer->deserialize(
                $request->getContent(), PokemonDto::class, 'json'
            );
            
            $errors = $this->validator->validate($pokemonDto);
            if (count($errors) > 0) {
                return $this->json([
                    'status' => 'ERROR',
                    'message' => (string) $errors
                ], Response::HTTP_BAD_REQUEST);
            }
            
            $domainPokemon = $this->pokemonMapper->toDomain($pokemonDto);
            $this->createPokemonService->execute($domainPokemon);

            return $this->json([
                'status' => 'OK',
                'message' => "El pokémon {$domainPokemon->getName()} fue almacenado correctamente",
                'pokemon_id' => $domainPokemon->getId(),
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return $this->json([
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function listPokemons(): JsonResponse
    {
        try {
            $pokemonsData = $this->listPokemonsService->execute(10);
        
            return $this->json([
                'status' => 'OK',
                'total' => count($pokemonsData),
                'pokemon' => $pokemonsData,
            ]);
        } catch (Exception $e) {
            return $this->json([
                'status' => 'ERROR',
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }

       

        
    }

    public function findPokemon(string $name): JsonResponse
    {
        try {
            $pokemonData = $this->findPokemonService->execute($name);

            return $this->json([
                'status' => 'OK',
                'pokemon' => $pokemonData,
            ]);
        } catch (Exception $e) {
            return $this->json([
                'status' => 'ERROR',
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
    }

    // public function updatePokemon(string $name, Request $request): JsonResponse
    // {
    //     try {
    //         $pokemonDto = $this->serializer->deserialize(
    //             $request->getContent(), PokemonDto::class, 'json'
    //         );
            
    //         $errors = $this->validator->validate($pokemonDto);
    //         if (count($errors) > 0) {
    //             return $this->json([
    //                 'status' => 'ERROR',
    //                 'message' => (string) $errors
    //             ], Response::HTTP_BAD_REQUEST);
    //         }

    //         $newData = $this->pokemonMapper->toDomain($pokemonDto)->toArray();
    //         $updatedPokemon = $this->updatePokemonService->execute($name, $newData);

    //         return $this->json([
    //             'status' => 'OK',
    //             'message' => "El pokémon {$updatedPokemon->getName()} fue modificado correctamente",
    //             'pokemon_id' => $updatedPokemon->getId(),
    //         ]);

    //     } catch (NotFoundHttpException $e) {
    //         throw new NotFoundHttpException($e->getMessage());
    //     } catch (\Exception $e) {
    //         return $this->json([
    //             'status' => 'ERROR',
    //             'message' => $e->getMessage()
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    public function delete(string $name): JsonResponse
    {
        try {
            $this->deletePokemonService->execute($name);

            return $this->json([
                'status' => 'OK',
                'message' => "El pokémon {$name} fue eliminado correctamente",
            ]);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (\Exception $e) {
            return $this->json([
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}