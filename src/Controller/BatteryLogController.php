<?php

namespace App\Controller;

use App\Entity\BatteryLog;
use App\Service\LogMaker;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class BatteryLogController extends AbstractController
{
    
    public function __invoke(LogMaker $maker): BatteryLog
    {
        return $maker->makeLog();
    }

}
