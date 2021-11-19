<?php

namespace App\Controller;

use DateTime;

use App\Entity\BatteryLog;
use App\Entity\LogEntry;
use App\Repository\DroneRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class BatteryLogController extends AbstractController
{
    
    public function __invoke(DroneRepository $droneRepository): BatteryLog
    {
        $data = new BatteryLog();
        $data->setTimestamp(new DateTime());

        $drones = $droneRepository->findAll();
        foreach ($drones as $drone) {
            $entry = new LogEntry();
            $entry->setDrone($drone);
            $entry->setBattery($drone->getBattery());

            $data->addEntry($entry);
        }
        return $data;
    }

}
