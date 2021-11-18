<?php

namespace App\Controller;

use App\Entity\Drone;
use App\Entity\DroneState;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class DroneStateController extends AbstractController
{

    private $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Drone $data): Drone
    {
        $new  = $data->getState()->getId();

        if ($new == DroneState::LOADING) {
            throw new BadRequestException("Please use the endpoint '/api/drones/{serial}/load' for load a drone");
        }

        $uow = $this->em->getUnitOfWork();
        $uow->computeChangeSets();
        $changes = $uow->getEntityChangeSet($data);

        $curr = $changes['state'][0]->id;
        
        if ($new == $curr) {
            throw new BadRequestException("The sate can't be the same that the drone alreay has");
        } elseif ($new == DroneState::IDLE) {
            if (!in_array($curr, [DroneState::LOADING, DroneState::LOADED, DroneState::RETURNING])) {
                throw new BadRequestException("This state is not allowed. Drone should be " . 
                    "Loading, Loaded or Delivering");
            } else {
                $data->clearPayload();
            }
        } else if ($new == DroneState::LOADED) {
            if ($curr != DroneState::LOADING) {
                throw new BadRequestException("This state is not allowed. Drone should be Loading");
            } elseif ($data->isEmpty()) {
                throw new BadRequestException("This drone is empty");
            }
        } else if ($new == DroneState::DELIVERING && $curr != DroneState::LOADED) {
            throw new BadRequestException("This state is not allowed. Drone should be loaded");
        } else if ($new == DroneState::DELIVERED && $curr != DroneState::DELIVERING) {
            throw new BadRequestException("This state is not allowed. Drone should be delivering");
        } else if ($new == DroneState::RETURNING && 
                ($curr != DroneState::DELIVERING || $curr != DroneState::DELIVERED)) {
            throw new BadRequestException("This state is not allowed. Drone should be ".
                "Delivering or Delivered");
        }

        

        return $data;
    }

}
