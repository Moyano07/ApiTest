<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Project;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;


/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    private function construct(){}

    public static function create($name,$description,Project $project)
    {
        $task = new Task();
        $task->setName($name);
        $task->setDescription($description);
        $task->setProject($project);

        return $task;

    }

    public function update(Request $request,Project $proyect)
    {
        $this->setName($request->get('name'));
        $this->setDescription($request->get('description'));
        $this->setProject($proyect);
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
        if (!$name) {
            throw new InvalidArgumentException('name is null');
        }
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        if (!$description) {
            throw new InvalidArgumentException('name is null');
        }
        $this->description = $description;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        if (!$project) {
            throw new InvalidArgumentException('project is null');
        }
        $this->project = $project;

        return $this;
    }
}
