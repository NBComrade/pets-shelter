<?php

require __DIR__ . '/../vendor/autoload.php';

$shelter = new \App\Shelter();

$bobby = new \App\Pets\Doggy('Bobby', 3);
$jack = new \App\Pets\Cat('Jack', 5);
$mike = new \App\Pets\Cat('Mike', 2);

$shelter->put($bobby);
sleep(1); //delay for stay of the pet in the shelter
$shelter->put($jack);
sleep(1);
$shelter->put($mike);

$oldestCat = $shelter->getOlderPetByType(\App\Pets\Cat::class);

echo $oldestCat->getName() . PHP_EOL; //expected 'Jack'
