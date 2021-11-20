<?php

namespace App\Command;

use App\Service\LogMaker;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:drone-battery',
    description: 'Creates a log with all batteries levels.',
)]
class DroneBatteryCommand extends Command
{
    
    private $logMaker;
    private $em;

    public function __construct(LogMaker $logMaker, EntityManagerInterface $em)
    {
        parent::__construct();

        $this->logMaker = $logMaker;
        $this->em = $em;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->info('Creating log');
        
        $data = $this->logMaker->makeLog();
        $this->em->persist($data);
        $this->em->flush();

        $rows = [];
        foreach ($data->getEntries() as $row) {
            $rows[] = [$row->getDrone()->getSerial(), $row->getBattery()];
        }

        $table = new Table($output);
        $table
            ->setHeaders(['Drone', 'Battery level'])
            ->setRows($rows);
        $table->render();

        $io->success('A log has been created');

        return Command::SUCCESS;
    }
}
