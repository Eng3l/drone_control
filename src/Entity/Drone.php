<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

use App\Repository\DroneRepository;
use App\Validator as Validator;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * 
 * @ORM\Entity(repositoryClass=DroneRepository::class)
 * @UniqueEntity("serial", message="There is a Drone with this serial number")
 */
#[
    ApiResource(
        normalizationContext:[
            'groups' => ['get']
        ],
        denormalizationContext:[
            'groups' => ['post']
        ],
        itemOperations:[
            'get', 'delete',
            'load' => [
                'summary' => 'Tries to load a drone with medications',
                'method' => 'POST',
                'path' => '/drones/{serial}/load',
                'controller' => \App\Controller\DroneLoaderController::class,
                'denormalization_context' => ['groups' => 'load'],
            ]
        ]
    )
]
class Drone
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Drone serial number must be not larger that 100 characters"
     * )
     * @Groups({"get", "post"})
     */
    private $serial;

    /**
     * @ORM\Column(type="float")
     * @Assert\LessThanOrEqual(500)
     * @Assert\Positive
     * @Groups({"get", "post"})
     */
    private $weight;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThanOrEqual(100)
     * @Assert\Positive
     * @Groups({"get", "post"})
     */
    private $battery;

    /**
     * @ORM\ManyToOne(targetEntity=DroneModel::class, inversedBy="drones")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource
     * @Groups({"get", "post"})
     */
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity=DroneState::class, inversedBy="drones")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource
     * @Groups({"get"})
     */
    private $state;

    /**
     * @ORM\ManyToMany(targetEntity=Medication::class, inversedBy="drones")
     * @ORM\JoinTable("drone_medication",
     *     joinColumns={@ORM\JoinColumn(name="drone_serial", referencedColumnName="serial")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="medication_id")}
     * )
     * @ApiSubresource
     * @Validator\MaxLoad()
     * @Groups({"get", "load"})
     */
    private $payload;

    public function __construct()
    {
        $this->payload = new ArrayCollection();
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(string $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

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

    public function getModel(): ?DroneModel
    {
        return $this->model;
    }

    public function setModel(?DroneModel $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getState(): ?DroneState
    {
        return $this->state;
    }

    public function setState(?DroneState $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection|Medication[]
     */
    public function getPayload(): Collection
    {
        return $this->payload;
    }

    public function addPayload(Medication $payload): self
    {
        if (!$this->payload->contains($payload)) {
            $this->payload[] = $payload;
        }

        return $this;
    }

    public function removePayload(Medication $payload): self
    {
        $this->payload->removeElement($payload);

        return $this;
    }
}
