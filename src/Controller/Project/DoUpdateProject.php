<?php


namespace App\Controller\Project;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityNotFoundException;
use App\Repository\ProjectRepository;



class DoUpdateProject{

    /**
     * @var ProjectRepository
     */
    private $porjectRepository;

    public function __construct(ProjectRepository $porjectRepository)
    {
        $this->porjectRepository = $porjectRepository;

    }

    /**
     * @Route("/project/update", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $projectId = $request->get('projectId');
        /** @var $poject Project */
        $project = $this->porjectRepository->findOneBy(['id'=>$projectId]);

        if(is_null($project))
        {
            throw new EntityNotFoundException('Project');

        }

        $project->update($request);

        return $project;
    }
     
}