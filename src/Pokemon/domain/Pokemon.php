<?php

namespace App\Pokemon\domain;

class Pokemon
{
    private int $id;
    private string $name;
    private int $height;
    private int $weight;
    private int $baseExperience;
    private array $abilities;
    private array $stats;
    private array $types;

    public function __construct(
        int $id,
        string $name,
        int $height,
        int $weight,
        int $baseExperience,
        array $abilities,
        array $stats,
        array $types
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->height = $height;
        $this->weight = $weight;
        $this->baseExperience = $baseExperience;
        $this->abilities = $abilities;
        $this->stats = $stats;
        $this->types = $types;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getBaseExperience(): int
    {
        return $this->baseExperience;
    }

    public function getAbilities(): array
    {
        return $this->abilities;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

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