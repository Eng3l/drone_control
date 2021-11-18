<?php

namespace App\Controller;

use App\Entity\Drone;
use App\Repository\DroneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class DroneAvailableController extends AbstractController
{

    public function __invoke(Request $request, DroneRepository $droneRepository)
    {
        $page = (int) $request->query->get('page', 1);
        return $droneRepository->getDronesByAvailability($page);
    }

}
