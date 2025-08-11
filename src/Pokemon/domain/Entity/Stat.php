<?php

namespace App\Pokemon\domain\Entity;

class Stat
{
    public function __construct(
        private int $id,
        private string $name,
        private int $base_stat,
        private int $effort,
    ) { }

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

    public function getBaseStat(): int
    {
        return $this->base_stat;
    }

    public function setBaseStat(int $base_stat): static
    {
        $this->base_stat = $base_stat;

        return $this;
    }

    public function getEffort(): int
    {
        return $this->effort;
    }

    public function setEffort(int $effort): static
    {
        $this->effort = $effort;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'base_stat' => $this->base_stat,
            'effort' => $this->effort,
        ];
    }
}