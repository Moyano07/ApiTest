<?php


namespace App\Controller\Project;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityNotFoundException;
use App\Repository\ProjectRepository;
use Symfony\Component\Security\Core\Security;


class DoDeleteProject{
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
     * @Route("/api/project/delete", methods={"DELETE"})
     */
    public function __invoke(Request $request)
    {
        /** @var  $project Project */
        $project = $this->porjectRepository->findOneBy(['id'=>$request->get('projectId'),
                                                        'user'=> $this->security->getUser()
        ]);
        if(is_null($project))
        {
            throw new EntityNotFoundException('Project');

        }

        $this->porjectRepository->remove($project);

        return ['success'];

    }
}