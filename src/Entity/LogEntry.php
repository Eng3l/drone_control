<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LogEntryRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LogEntryRepository::class)
 */
#[ApiResource(
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => 'read'],
        ]
    ],
    collectionOperations: ['get']
)]
class LogEntry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read", "create"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Drone::class)
     * @ORM\JoinColumn(nullable=false, referencedColumnName="serial")
     * @Groups({"read", "create"})
     */
    private $drone;

    /**
     * @ORM\ManyToOne(targetEntity=BatteryLog::class, inversedBy="entries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $log;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read", "create"})
     */
    private $battery;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDrone(): ?Drone
    {
        return $this->drone;
    }

    public function setDrone(?Drone $drone): self
    {
        $this->drone = $drone;

        return $this;
    }

    public function getBattery(): ?int
    {
        return $this->battery;
    }

    public function setBattery(int $battery): self
    {
        $this->battery = $battery;

        return $this;
    }

    public function getLog(): ?BatteryLog
    {
        return $this->log;
    }

    public function setLog(?BatteryLog $log): self
    {
        $this->log = $log;

        return $this;
    }
}
