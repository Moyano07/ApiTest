<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegisterUser{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    


    public function __construct(UserRepository $userRepository,
                                UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * @Route("/api/user/register", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $username = $request->get('username');

        $this->uniqueUserNameGuard($username);

        /** @var  $user User */
        $user = User::create(
            $username
        );

        $password = $this->passwordEncoder->encodePassword($user, $request->get('password'));
        $user->setPassword($password);


        $this->userRepository->persist($user);

        return $user;


    }

    private function uniqueUserNameGuard($username)
    {
        $user = $this->userRepository->findOneBy(['username' => $username]);
        if ($user) {
            throw new Exception('USERNAME_ALREADY_EXIST');
        }
    }
}