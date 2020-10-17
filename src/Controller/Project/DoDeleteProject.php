<?php


namespace App\Controller\Project;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityNotFoundException;
use App\Repository\ProjectRepository;

class DoDeleteProject{
    /**
     * @var ProjectRepository
     */
    private $porjectRepository;

    public function __construct(ProjectRepository $porjectRepository)
    {
        $this->porjectRepository = $porjectRepository;

    }

    /**
     * @Route("/project/delete", methods={"DELETE"})
     */
    public function __invoke(Request $request)
    {
        /** @var  $project Project */
        $project = $this->porjectRepository->findOneBy(['id'=>$request->get('projectId')]);

        if(is_null($project))
        {
            throw new EntityNotFoundException('Project');

        }

        $this->porjectRepository->remove($project);


    }
}