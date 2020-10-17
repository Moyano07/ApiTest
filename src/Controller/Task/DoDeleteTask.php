<?php


namespace App\Controller\Task;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityNotFoundException;
use App\Repository\TaskRepository;
use App\Repository\ProjectRepository;




class DoDeleteTask{

    /**
     * @var TaskRepository
     */
    private $taskRepository;



    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;

    }

    /**
     * @Route("/task/delete", methods={"DELETE"})
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

        $this->taskRepository->remove($task);

    }
    
}