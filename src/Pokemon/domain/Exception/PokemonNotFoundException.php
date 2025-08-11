<?php

namespace App\Pokemon\domain\Exception;

use Exception;

class PokemonNotFoundException extends Exception
{
    public function __construct(string $name)
    {
        parent::__construct(sprintf('Pokemon "%s" no encontrado ;c', $name));
    }
}