<?php

namespace App\Pokemon\infrastructure\dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Pokemon\infrastructure\dto\AbilityDto;
use App\Pokemon\infrastructure\dto\StatDto;
use App\Pokemon\infrastructure\dto\TypeDto;

class PokemonDto
{
    #[Assert\NotBlank(message: 'El nombre no puede estar vacío.')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'El nombre debe tener al menos 3 caracteres.')]
    public string $name;
    
    #[Assert\NotBlank(message: 'La altura no puede estar vacía.')]
    #[Assert\PositiveOrZero(message: 'La altura debe ser un número entero positivo.')]
    #[Assert\Length(min: 1, max: 3, minMessage: 'La altura debe tener al menos 1 dígito y máximo 3 dígitos')]
    public int $height;
    
    #[Assert\NotBlank(message: 'El peso no puede estar vacío.')]
    #[Assert\PositiveOrZero(message: 'El peso base debe ser un número entero positivo.')]
    #[Assert\Length(min: 1, max: 3, minMessage: 'El peso debe tener al menos 1 dígito y máximo 3 dígitos.')]
    public int $weight;
    
    #[Assert\NotBlank(message: 'La experiencia base no puede estar vacía.')]
    #[Assert\PositiveOrZero(message: 'La experiencia base debe ser un número entero positivo.')]
    public int $base_experience;

    /**
     * @var AbilityDto[]
     */
    public array $abilities;

    /**
     * @var StatDto[]
     */
    public array $stats;

    /**
     * @var TypeDto[]
     */
    public array $types;
}