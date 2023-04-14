<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post as PostMeta;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[GetCollection(
    normalizationContext: ['groups'=>['read:User:Collection']],
)]
#[Get(normalizationContext:['groupes'=>['read:User:Unique',"read:User:Collection"]])]
#[Put()]
#[Delete()]
#[PostMeta()]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:User:Collection','read:Post:Collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:User:Collection','read:Post:Collection'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:User:Collection'])]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:User:Collection'])]
    private ?string $role = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups(['read:User:Collection','read:Post:Collection'])]
    private ?Niveau $niveau = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'users')]
    #[Groups(['read:User:Unique'])]
    private Collection $tags;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Post::class, orphanRemoval: true)]
    #[Groups(['read:User:Unique'])]
    private Collection $posts;

    #[ORM\OneToMany(mappedBy: 'userID', targetEntity: Answer::class, orphanRemoval: true)]
    #[Groups(['read:User:Unique'])]
    private Collection $answers;

    #[Groups(['read:User:Collection'])]
    #[ORM\Column]
    private ?int $point = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->answers = new ArrayCollection();
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setUserId($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUserId() === $this) {
                $post->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setUserID($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getUserID() === $this) {
                $answer->setUserID(null);
            }
        }

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }
}
