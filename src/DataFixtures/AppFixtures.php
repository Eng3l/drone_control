<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\DroneModel;
use App\Entity\DroneState;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $models = ['Lightweight','Middleweight','Cruiserweight','Heavyweight'];
        foreach ($models as $model) {
            $entity = new DroneModel();
            $entity->setModel($model);

            $manager->persist($entity);
        }

        $states = ["IDLE", "LOADING", "LOADED", "DELIVERING", "DELIVERED", "RETURNING"];
        foreach ($states as $state) {
            $entity = new DroneState();
            $entity->setState($state);

            $manager->persist($entity);
        }

        $manager->flush();
    }
}
