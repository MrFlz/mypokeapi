<?php

namespace App\Pokemon\domain\Entity;

class Ability
{
    public function __construct(
        private int $id,
        private string $name,
        private bool $is_hidden,
        private int $slot,
    )
    { }

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

    public function isHidden(): bool
    {
        return $this->is_hidden;
    }

    public function setIsHidden(bool $is_hidden): static
    {
        $this->is_hidden = $is_hidden;

        return $this;
    }

    public function getSlot(): int
    {
        return $this->slot;
    }

    public function setSlot(int $slot): static
    {
        $this->slot = $slot;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_hidden' => $this->is_hidden,
            'slot' => $this->slot,
        ];
    }
}
