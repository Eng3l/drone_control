<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MedicationRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=MedicationRepository::class)
 * @UniqueEntity("code", message="There is a Medication with that code")
 */
#[ApiResource(
    itemOperations: ['get', 'delete'],
    collectionOperations: [
        'get',
        'post' => [
            'controller' => \App\Controller\MedicationController::class,
            'deserialize' => false,
            'openapi_context' => [
                'summary' => 'Creates a new Medication with image',
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => [
                                        'description' => 'Name of the medication',
                                        'type' => 'string',
                                        'example' => 'Aspirine'
                                    ],
                                    'weight' => [
                                        'description' => 'Weight of the medication',
                                        'type' => 'float',
                                        'example' => '10.0'
                                    ],
                                    'code' => [
                                        'description' => 'Code of the medication',
                                        'type' => 'string',
                                        'example' => 'AABBCC11'
                                    ],
                                    'image' => [
                                        'description' => 'A picture of the medication',
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
)]
class Medication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex("/^(\w|-|_)+$/")
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex("/^([A-Z]|_|[0-9])+$/")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @ApiProperty(
     *   iri="http://schema.org/image",
     *   attributes={
     *     "openapi_context"={
     *       "type"="string",
     *     }
     *   }
     * )
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Drone::class, mappedBy="payload")
     * @ORM\JoinTable("drone_medication",
     *     joinColumns={@ORM\JoinColumn(name="medication_id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="drone_serial", referencedColumnName="serial")}
     * )
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
            $drone->addPayload($this);
        }

        return $this;
    }

    public function removeDrone(Drone $drone): self
    {
        if ($this->drones->removeElement($drone)) {
            $drone->removePayload($this);
        }

        return $this;
    }
}
