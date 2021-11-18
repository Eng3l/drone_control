<?php

namespace App\EventListener;

use App\Entity\Drone;
use App\Entity\DroneState;

use Doctrine\Persistence\Event\LifecycleEventArgs;

class DroneStateCreate 
{

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Drone) {
            //this listener only applies for drone
            return;
        }

        $repo = $args->getObjectManager()->getRepository(DroneState::class);
        $state = $repo->find(DroneState::IDLE);
        $entity->setState($state);
    }

}