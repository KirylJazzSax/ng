<?php

namespace App\Entity\Post;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\v1\PostController;
use App\Entity\Post\PostStatus;
use App\Entity\Post\PostType;
use App\Entity\User\User;
use App\Repository\PostRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="PostRepository::class")
 */
#[
    ApiResource(
        collectionOperations: [
            'create_post_default' => [
                'method' => 'post',
                'path' => '/v1/post',
                'controller' => PostController::class,
                'status' => 201,
            ]
        ],
        itemOperations: []
    )
]
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    #[ORM\Column(type: 'text'), Groups(['default'])]
    private $title;

    #[ORM\Column(type: 'text', nullable: true), Groups(['default'])]
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="text")
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="posts")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function setStatusNew(): self
    {
        return $this->setStatus(PostStatus::NEW);
    }

    public function setDefaultType(): self
    {
        return $this->setType(PostType::DEFAULT);
    }

    public static function default(string $title, string $description, UserInterface $user): self
    {
        return (new Post())
            ->setStatusNew()
            ->setDefaultType()
            ->setTitle($title)
            ->setUser($user)
            ->setDescription($description)
            ->setCreatedAt(new DateTimeImmutable());
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): self
    {
        $this->user = $user;
        return $this;
    }
}
