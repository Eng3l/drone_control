<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

use App\Repository\DroneModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=DroneModelRepository::class)
 * @ApiResource(
 *      itemOperations={"get"={"path"="model/{id}"}},
 *      collectionOperations={"get"}
 * )
 */
class DroneModel
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\OneToMany(targetEntity=Drone::class, mappedBy="model", orphanRemoval=true)
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

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

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
            $drone->setModel($this);
        }

        return $this;
    }

    public function removeDrone(Drone $drone): self
    {
        if ($this->drones->removeElement($drone)) {
            // set the owning side to null (unless already changed)
            if ($drone->getModel() === $this) {
                $drone->setModel(null);
            }
        }

        return $this;
    }
}
