<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

use App\Repository\BatteryLogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BatteryLogRepository::class)
 */
#[ApiResource(
    shortName: 'Drone batteries log',
    description: 'Log with drone\'s batteries levels at some point.',
    itemOperations: [
        'get' => [
            'path' => '/battery_logs/{id}',
        ]
    ],
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => 'create'],
            'path' => '/battery_logs'
        ],
        'post' => [
            'openapi_context' => [
                'summary' => 'Creates a new Log.',
                'description' => 'This logs contains all drones with its battery level'
            ],
            'method' => 'POST',
            'path' => '/battery_logs',
            'controller' => \App\Controller\BatteryLogController::class,
            'denormalization_context' => ['groups' => ''],
            'normalization_context' => ['groups' => 'create'],
            'deserialize' => false,
            'operation_name' => 'get'
        ]
    ]
)]
class BatteryLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"create"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"create"})
     */
    private $timestamp;

    /**
     * @ORM\OneToMany(targetEntity=LogEntry::class, mappedBy="log", orphanRemoval=true,
     * cascade={"persist"})
     * @Groups({"create"})
     */
    private $entries;

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return Collection|LogEntry[]
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function addEntry(LogEntry $entry): self
    {
        if (!$this->entries->contains($entry)) {
            $this->entries[] = $entry;
            $entry->setLog($this);
        }

        return $this;
    }

    public function removeEntry(LogEntry $entry): self
    {
        if ($this->entries->removeElement($entry)) {
            // set the owning side to null (unless already changed)
            if ($entry->getLog() === $this) {
                $entry->setLog(null);
            }
        }

        return $this;
    }
}
