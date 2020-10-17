<?php


namespace App\Controller\Task;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityNotFoundException;
use App\Repository\TaskRepository;


class QueryTasksByProject{

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    private $security;

    public function __construct(ProjectRepository $projectRepository,
                                Security $security,
                                TaskRepository $taskRepository
                                )
    {
        $this->projectRepository = $projectRepository;
        $this->security = $security;
        $this->taskRepository = $taskRepository;

    }

    /**
     * @Route("/api/get-tasks-by-project", methods={"GET"})
     */
    public function __invoke(Request $request)
    {
        //dd($request->get('projectId'));
        /** @var $project Project */
        $project = $this->projectRepository->findOneBy([
                                            'user'=>$this->security->getUser(),
                                            'id' => $request->get('projectId')
                                            ]);
        if(is_null($project)){
            throw new EntityNotFoundException('Project');
        }

        //$tasks = $this->taskRepository->findBy(['project' => $project]);
        
        return $project->getTasks();
    }
}