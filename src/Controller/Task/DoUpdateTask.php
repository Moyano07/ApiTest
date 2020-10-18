<?php


namespace App\Controller\Task;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityNotFoundException;
use App\Repository\TaskRepository;
use App\Repository\ProjectRepository;




class DoUpdateTask{

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
     * @Route("/api/task/update", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $taskId = $request->get('taskId');
        /** @var $task Task */
        $task = $this->taskRepository->findOneBy(['id'=>$taskId]);

        if(is_null($task))
        {
            throw new EntityNotFoundException('Task');
        }

        $projectId = $request->get('projectId');
        /** @var $poject Project */
        $project = $this->projectRepository->findOneBy(['id'=>$projectId]);

        if(is_null($project))
        {
            throw new EntityNotFoundException('Project');

        }

        $task->update($request,$project);

        $this->taskRepository->persist($task);

        return $task;
    }
     
}