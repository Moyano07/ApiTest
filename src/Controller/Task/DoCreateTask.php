<?php


namespace App\Controller\Task;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TaskRepository;
use App\Repository\ProjectRepository;
use App\Entity\Task;


class DoCreateTask{

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    


    public function __construct(TaskRepository $taskRepository,
                                ProjectRepository $projectRepository
                                )
    {
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;

    }

    /**
     * @Route("/api/task/create", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $task = Task::create(
            $request->get('name'),
            $request->get('description'),
            $this->projectRepository->findOneBy(['id'=>$request->get('projectId')])
        );

        $this->taskRepository->persist($task);

        return $task;
    }
       
}