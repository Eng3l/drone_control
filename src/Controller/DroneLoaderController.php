<?php

namespace App\Controller;

use App\Entity\Drone;
use App\Entity\DroneState;
use App\Repository\DroneStateRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Attribute\AsController;

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
        $data->setState($this->stateRepo->find(DroneState::LOADING));

        return $data;
    }

}
