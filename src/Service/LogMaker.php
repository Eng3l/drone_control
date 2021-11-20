<?php
 
namespace App\Service;

use DateTime;

use App\Entity\BatteryLog;
use App\Entity\LogEntry;
use App\Repository\DroneRepository;

/**
 * Common service to create Drone battery levels.
 */
class LogMaker
{

    private $droneRepository;

    public function __construct(DroneRepository $droneRepository)
    {
        $this->droneRepository = $droneRepository;
    }

    public function makeLog(): BatteryLog
    {
        $data = new BatteryLog();
        $data->setTimestamp(new DateTime());

        $drones = $this->droneRepository->findAll();
        foreach ($drones as $drone) {
            $entry = new LogEntry();
            $entry->setDrone($drone);
            $entry->setBattery($drone->getBattery());

            $data->addEntry($entry);
        }
        return $data;
    }

}