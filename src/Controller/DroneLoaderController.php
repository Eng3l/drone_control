<?php

namespace App\Controller;

use App\Entity\Drone;
use App\Entity\DroneState;
use App\Repository\DroneStateRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Attribute\AsController;

/**
 * Unsures that a drone can't be loaded if its battery is below 25%
 * and it's state is IDLE or LOADING
 */
#[AsController]
class DroneLoaderController extends AbstractController
{

    private $stateRepo;

    function __construct(DroneStateRepository $stateRepo)
    {
        $this->stateRepo = $stateRepo;
    }

    public function __invoke(Drone $data): Drone
    {
        if ($data->getBattery() < 25) {
            throw new BadRequestException('Low level battery.');
        }
        else if ($data->getState()->getId() > DroneState::LOADING) {
            throw new BadRequestException('This drone is not available for loading');
        }
        $sum = 0;
        foreach ($data->getPayload() as $load) {
            $sum += $load->getWeight();
        }
        
        if ($sum == $data->getWeight()) {
            $data->setState($this->stateRepo->find(DroneState::LOADED));
        } else {
            $data->setState($this->stateRepo->find(DroneState::LOADING));
        }

        return $data;
    }

}
