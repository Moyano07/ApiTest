<?php


namespace App\Controller\Project;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityNotFoundException;
use App\Repository\ProjectRepository;
use Symfony\Component\Security\Core\Security;



class DoUpdateProject{

    /**
     * @var ProjectRepository
     */
    private $porjectRepository;

    private $security;

    public function __construct(ProjectRepository $porjectRepository,
                                Security $security
                                )
    {
        $this->porjectRepository = $porjectRepository;
        $this->security = $security;
    }
    /**
     * @Route("/api/project/update", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $projectId = $request->get('projectId');
        /** @var $poject Project */
        $project = $this->porjectRepository->findOneBy(['id'=>$projectId,
                                                        'user'=> $this->security->getUser()
                                                        ]);

        if(is_null($project))
        {
            throw new EntityNotFoundException('Project');

        }

        $project->update($request);

        return $project;
    }
     
}