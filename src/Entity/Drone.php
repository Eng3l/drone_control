<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

use App\Repository\DroneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 *      itemOperations={"get", "delete"}
 * )
 * @ORM\Entity(repositoryClass=DroneRepository::class)
 * @UniqueEntity("serial", message="There is a Drone with this serial number")
 */
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
     */
    private $serial;

    /**
     * @ORM\Column(type="float")
     * @Assert\LessThanOrEqual(500)
     * @Assert\Positive
     */
    private $weight;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThanOrEqual(100)
     * @Assert\Positive
     */
    private $battery;

    /**
     * @ORM\ManyToOne(targetEntity=DroneModel::class, inversedBy="drones")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource
     */
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity=DroneState::class, inversedBy="drones")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource
     */
    private $state;

    /**
     * @ORM\ManyToMany(targetEntity=Medication::class, inversedBy="drones")
     * @ORM\JoinTable("drone_medication",
     *     joinColumns={@ORM\JoinColumn(name="drone_serial", referencedColumnName="serial")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="medication_id")}
     * )
     * @ApiSubresource
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
