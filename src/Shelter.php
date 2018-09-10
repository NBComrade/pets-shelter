<?php

namespace App;

use App\Base\PetRecord;
use App\Exceptions\InvalidPetTypeException;
use App\Interfaces\PetInterface;
use App\Pets\{
    Cat,
    Doggy,
    Tortoise
};

/**
 * Class Shelter
 * @package App
 */
class Shelter
{
    /** @var PetRecord[] */
    private $petsRecords = [];

    protected const ALLOWED_PETS_TYPES = [
        Doggy::class,
        Cat::class,
        Tortoise::class
    ];

    public function put(PetInterface $pet): void
    {
        $this->ensurePetType($pet->getType());
        $this->petsRecords[] = PetRecord::create($pet);
    }

    public function getPetsByType(string $type): array
    {
        $pets = [];

        foreach ($this->petsRecords as $petRecord) {
            if ($petRecord->getType() === $type) {
                $pets[] = $petRecord->getInstance();
            }
        }

        return $pets;
    }

    public function getOlderPet(string $type): PetInterface
    {
        
    }

    public function getOlderPetByType(string $type): PetInterface
    {

    }

    /**
     * @param string $type
     * @throws InvalidPetTypeException
     */
    private function ensurePetType(string $type): void
    {
        if (!in_array($type, self::ALLOWED_PETS_TYPES, true)) {
            throw new InvalidPetTypeException();
        }
    }
}
