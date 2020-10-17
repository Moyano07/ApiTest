<?php


namespace App\Controller\Project;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;
use Symfony\Component\Security\Core\Security;


class QueryProjectsByUser{

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
     * @Route("/api/get-projects", methods={"GET"})
     */
    public function __invoke(Request $request)
    {
        /** @var $poject Project */
        $projects = $this->porjectRepository->findBy(['user'=>$this->security->getUser()]);

        
        return $projects;
    }
}