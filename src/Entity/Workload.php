<?php

namespace App\Entity;

use App\Repository\WorkloadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkloadRepository::class)]
class Workload
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $hours_planned = null;

    #[ORM\Column]
    private ?int $week = null;

    #[ORM\Column(nullable: true)]
    private ?float $work_done = null;

    #[ORM\ManyToOne(targetEntity: Worker::class, inversedBy: 'workloads')]
    private $worker;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'workloads')]
    private $project;

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project): void
    {
        $this->project = $project;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHoursPlanned(): ?float
    {
        return $this->hours_planned;
    }

    public function setHoursPlanned(float $hours_planned): static
    {
        $this->hours_planned = $hours_planned;

        return $this;
    }

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(int $week): static
    {
        $this->week = $week;

        return $this;
    }

    public function getWorkDone(): ?float
    {
        return $this->work_done;
    }

    public function setWorkDone(?float $work_done): static
    {
        $this->work_done = $work_done;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorker()
    {
        return $this->worker;
    }

    /**
     * @param mixed $worker
     */
    public function setWorker($worker): void
    {
        $this->worker = $worker;
    }
}
