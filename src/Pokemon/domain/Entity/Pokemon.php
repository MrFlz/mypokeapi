<?php

namespace App\Pokemon\domain\Entity;

class Pokemon
{
    public function __construct(
        private int $id,
        private string $name,
        private int $height,
        private int $weight,
        private int $baseExperience,
        private array $abilities,
        private array $stats,
        private array $types
    ) { }

    // Métodos Getters (necesarios para acceder a las propiedades)
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getBaseExperience(): int
    {
        return $this->baseExperience;
    }

    public function setBaseExperience(int $baseExperience): static
    {
        $this->baseExperience = $baseExperience;

        return $this;
    }

    public function getAbilities(): array
    {
        return $this->abilities;
    }

    public function setAbilities(array $abilities): static
    {
        $this->abilities = $abilities;

        return $this;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function setStats(array $stats): static
    {
        $this->stats = $stats;

        return $this;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function setTypes(array $types): static
    {
        $this->types = $types;

        return $this;
    }

    // Método para convertir el objeto a un array (útil para la respuesta JSON)
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'height' => $this->height,
            'weight' => $this->weight,
            'base_experience' => $this->baseExperience,
            'abilities' => $this->abilities,
            'stats' => $this->stats,
            'types' => $this->types,
        ];
    }
}