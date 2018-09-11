<?php

use App\Base\Pet;
use App\Exceptions\InvalidPetTypeException;
use App\Interfaces\PetInterface;
use \PHPUnit\Framework\TestCase;
use App\Shelter;
use App\Pets\{
    Doggy, Cat, Tortoise
};

class ShelterTest extends TestCase
{
    /**@var Shelter*/
    private $shelter;

    protected function setUp()
    {
        $this->shelter = new Shelter();
        parent::setUp();
    }

    protected function putPetsToShelterWithDaley(): void
    {
        sleep(1); //delay for stay of the pet in the shelter
        $this->shelter->put(new Cat('Jack', 5));
        sleep(1);
        $this->shelter->put(new Cat('Mike', 5));
        sleep(1);
        $this->shelter->put(new Tortoise('Julia', 78));
        sleep(1);
        $this->shelter->put(new Tortoise('Nikki', 43));
        sleep(1);
        $this->shelter->put(new Tortoise('Tom', 93));
    }

    public function testPut(): void
    {
        $pet = new Doggy('Bobby', 3);

        $this->assertInstanceOf(PetInterface::class, $pet);

        $this->shelter->put($pet);

        $pets = $this->shelter->getPetsByType(Doggy::class);

        $this->assertCount(1, $pets);
        $this->assertEquals('Bobby', reset($pets)->getName());
        $this->assertEquals(Doggy::class, reset($pets)->getType());
    }

    public function testExceptionOnPutInvalidType(): void
    {
        $this->expectException(InvalidPetTypeException::class);

        $pet = new class implements PetInterface {
            public function getType(): string
            {
               return get_class($this);
            }
        };

        $this->shelter->put($pet);
    }

    public function testGetPetsByType(): void
    {
        $this->putPetsToShelterWithDaley();
        $pets = $this->shelter->getPetsByType(Tortoise::class);
        $this->assertCount(3, $pets);

        //Test alphabetical order
        $this->assertEquals('Julia', reset($pets)->getName());
        $this->assertEquals('Tom', end($pets)->getName());
    }

    public function testGetPetsByTypeThatNotExists(): void
    {
        $pets = $this->shelter->getPetsByType(Pet::class);
        $this->assertEmpty($pets);
    }

    public function testGetOlderPet(): void
    {
        $this->putPetsToShelterWithDaley();
        $oldestPet = $this->shelter->getOlderPet();
        $this->assertEquals('Jack', $oldestPet->getName());
        $this->assertEquals(Cat::class, $oldestPet->getType());
    }

    public function testGetOlderPetByType(): void
    {
        $this->putPetsToShelterWithDaley();
        $oldestTortoise = $this->shelter->getOlderPetByType(Tortoise::class);
        $this->assertEquals('Julia', $oldestTortoise->getName());
        $this->assertEquals(Tortoise::class, $oldestTortoise->getType());
    }
}
