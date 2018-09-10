<?php

namespace App\Base;

use App\Interfaces\PetInterface;

/**
 * Class PetRecord - Pet instance with meta-data
 * @package App\Base
 */
class PetRecord
{
    private $putted_at;

    private $type;

    /*** @var Pet */
    private $instance;

    public function __construct(PetInterface $pet)
    {
        $this->putted_at = time();
        $this->type = $pet->getType();
        $this->instance = $pet;
    }

    public static function create(PetInterface $pet): self
    {
        return new static($pet);
    }

    public function getPuttedAt(): int
    {
        return $this->putted_at;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getInstance(): PetInterface
    {
        return $this->instance;
    }
}
