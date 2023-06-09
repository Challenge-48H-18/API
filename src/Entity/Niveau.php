<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post as PostMeta;
use ApiPlatform\Metadata\Put;

#[GetCollection(
    normalizationContext: ['groups'=>['read:Niveau:Collection']],
)]
#[Get(normalizationContext:['groups'=>['read:Niveau:Unique',"read:Niveau:Collection"]])]
#[ORM\Entity(repositoryClass: NiveauRepository::class)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Niveau:Collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Niveau:Collection','read:Post:Collection'])]
    private ?string $name = null;

    #[Groups(['read:Niveau:Unique'])]
    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setNiveau($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getNiveau() === $this) {
                $user->setNiveau(null);
            }
        }

        return $this;
    }
}
