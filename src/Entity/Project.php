<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 16)]
    private ?string $short = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Workload::class)]
    private $workloads;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getShort(): ?string
    {
        return $this->short;
    }

    public function setShort(string $short): static
    {
        $this->short = $short;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkloads()
    {
        return $this->workloads;
    }

    /**
     * @param mixed $workloads
     */
    public function setWorkloads($workloads): void
    {
        $this->workloads = $workloads;
    }
}
