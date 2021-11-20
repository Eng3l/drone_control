<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

use App\Repository\DroneStateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=DroneStateRepository::class)
 * @ApiResource(
 *      itemOperations={"get"={"path"="states/{id}"}},
 *      collectionOperations={"get"}
 * )
 */
#[ApiResource(
    shortName: 'States of drone',
    description: 'Differents states of a drone',
    itemOperations: [
        'get' => [
            'path' => 'states/{id}'
        ]
    ],
    collectionOperations: [
        'get' => [
            'path' => 'states'
        ]
    ]
)]
class DroneState
{

    const IDLE          = 1;
    const LOADING       = 2;
    const LOADED        = 3;
    const DELIVERING    = 4;
    const DELIVERED     = 5;
    const RETURNING     = 6;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity=Drone::class, mappedBy="state", orphanRemoval=true)
     * @Ignore
     */
    private $drones;

    public function __construct()
    {
        $this->drones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection|Drone[]
     */
    public function getDrones(): Collection
    {
        return $this->drones;
    }

    public function addDrone(Drone $drone): self
    {
        if (!$this->drones->contains($drone)) {
            $this->drones[] = $drone;
            $drone->setState($this);
        }

        return $this;
    }

    public function removeDrone(Drone $drone): self
    {
        if ($this->drones->removeElement($drone)) {
            // set the owning side to null (unless already changed)
            if ($drone->getState() === $this) {
                $drone->setState(null);
            }
        }

        return $this;
    }
}
