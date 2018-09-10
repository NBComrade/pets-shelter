<?php

namespace App;

use App\Base\{
    Pet,
    PetRecord
};
use App\Pets\{
    Cat,
    Doggy,
    Tortoise
};
use App\Exceptions\InvalidPetTypeException;
use App\Interfaces\PetInterface;

/**
 * Class Shelter
 * @package App
 */
class Shelter
{
    /** @var PetRecord[] */
    private $petsRecords = [];

    private const ALLOWED_PETS_TYPES = [
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

        return $this->sortByPetsName($pets);
    }

    public function getOlderPet(): PetInterface
    {
        $pets = $this->sortByPushedAt();
        return array_shift($pets)->getInstance();
    }

    public function getOlderPetByType(string $type): ?PetInterface
    {
        $pets = $this->sortByPushedAt();

        foreach ($pets as $pet) {
            if ($pet->getType() === $type) {
                return $pet->getInstance();
            }
        }
    }

    private function sortByPushedAt(): array
    {
        $pets = $this->petsRecords;

        usort($pets, function (PetRecord $a, PetRecord $b) {
            return ($a->getPuttedAt() < $b->getPuttedAt()) ? -1 : 1;
        });

        return $pets;
    }

    protected function sortByPetsName(array $pets): array
    {
        usort($pets, function (Pet $a, Pet $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return $pets;
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
