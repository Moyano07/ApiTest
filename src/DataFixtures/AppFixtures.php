<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Project;
use App\Entity\Task;


class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    // ...
    public function load(ObjectManager $manager)
    {
        $users = [];
        for ($i=0; $i < 5; $i++) { 
            $user = User::create('User-'.$i);
            $password = $this->encoder->encodePassword($user, '1234');
            $user->setPassword($password);

            $manager->persist($user);
            $users[] = $user;
        }
        
        $projects = [];
        
        foreach ($users as $user) {
            for ($i=0; $i < 5; $i++) { 
                $project = Project::create(
                    'Project-'.$i,
                    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                    'project.png',
                    $user
                );
                $manager->persist($project);
                $projects[] = $project;
            }
           
        }

        
        foreach ($projects as $project) {
            for ($i=0; $i < 5; $i++) { 
                $task = Task::create(
                    'Task-'.$i,
                    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                    $project
                );
                $manager->persist($task);
                
            }
        }
        
        $manager->flush();
    }
}
