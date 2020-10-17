<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use InvalidArgumentException;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation as Serializer;




/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Exclude()
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="user")
     */
    private $projects;

    private function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public static function create($username)
    {
        $user = new User();
        $user->setUsername($username);

        return $user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        if (!$username) {
            throw new InvalidArgumentException('username is null');
        }
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        

        $this->password = $password;

        return $this;
    }

    /**
 	* @see UserInterface
 	*/
	public function getSalt()
                     	{
                         		// not needed when using the "bcrypt" algorithm in security.yaml
                     	}

	/**
 	* @see UserInterface
 	*/
	public function eraseCredentials()
                     	{
                         		// If you store any temporary, sensitive data on the user, clear it here
                         		// $this->plainPassword = null;
                         }
    
   
    public function getRoles()
	{
    		return [];
	}

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setUser($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getUser() === $this) {
                $project->setUser(null);
            }
        }

        return $this;
    }
}
