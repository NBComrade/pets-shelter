<?php

namespace App\Base;

use App\Interfaces\PetInterface;

/**
 * Class Pet - immutable object
 * @package App
 */
abstract class Pet implements PetInterface
{
    private $name;

    private $age;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getType(): string
    {
        return get_class($this);
    }
}
