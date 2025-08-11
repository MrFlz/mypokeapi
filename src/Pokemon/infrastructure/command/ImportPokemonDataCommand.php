<?php

namespace App\Pokemon\infrastructure\command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use App\Pokemon\infrastructure\Doctrine\Entity\Pokemon as DoctrinePokemon;
use App\Pokemon\infrastructure\Doctrine\Entity\Ability as DoctrineAbility;

#[AsCommand(
    name: 'app:import-pokemon-data',
    description: 'Consulta API externa (PokeAPI)',
)]
class ImportPokemonDataCommand extends Command
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $entityManager,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Importando Pokemones de PokeAPI...');

        $pokemonData = $this->httpClient->request('GET', 'https://pokeapi.co/api/v2/pokemon?limit=10')->toArray();

        foreach ($pokemonData['results'] as $result) {
            $pokemonDetails = $this->httpClient->request('GET', $result['url'])->toArray();

            $pokemon = new DoctrinePokemon();
            $pokemon->setName($pokemonDetails['name']);
            $pokemon->setHeight($pokemonDetails['height']);
            $pokemon->setWeight($pokemonDetails['weight']);
            $pokemon->setBaseExperience($pokemonDetails['base_experience']);

            foreach ($pokemonDetails['abilities'] as $abilityData) {
                // ... PENDIENTE lógica para manejar las habilidades
            }

            $this->entityManager->persist($pokemon);
        }

        $this->entityManager->flush();

        $io->success('Importación de pokemones completada.');
        return Command::SUCCESS;
    }
}
