<?php 
namespace App\Controller\Project;

use App\Entity\Project;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;
use Symfony\Component\Security\Core\Security;


class DoCreateProject{

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
     * @Route("/api/project/create", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        /** @var $poject Project */
        $project = Project::create(
            $request->get('name'),
            $request->get('description'),
            $request->get('image'),
            $this->security->getUser()
        );

        $this->porjectRepository->persist($project);

        return $project;
    }
}