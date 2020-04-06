<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      attributes={
 *         "order"={"id": "ASC"},
 *         "formats"={"json", "jsonld", "form"={"multipart/form-data"}}, "enable_max_depth"=true
 *      },
 *       itemOperations={
 *         "get"={
 *             "normalization_context"={
 *                 "groups"={"get-faculty","get","get-image"}
 *             }
 *         },
 *           "delete",
 *         "put"={
 *             "denormalization_context"={
 *                 "groups"={"put"}
 *             },
 *             "normalization_context"={
 *                 "groups"={"get"}
 *             }
 *         },
 *     },
 *     collectionOperations={
 *          "get"={"normalization_context"={"groups"={"collection-get"}}},
 *         "post"={
 *             "denormalization_context"={
 *                 "groups"={"post"}
 *             },
 *             "normalization_context"={
 *                 "groups"={"get"}
 *             },
 *             "validation_groups"={"post"}
 *         }
 *     },
 *         
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("username", groups={"post"})
 */
class User implements UserInterface
{
    const ROLE_COMMENTATOR = 'ROLE_COMMENTATOR';
    const ROLE_WRITER = 'ROLE_WRITER';
    const ROLE_EDITOR = 'ROLE_EDITOR';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';

    const DEFAULT_ROLES = [self::ROLE_COMMENTATOR];
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get","collection-get", "get-comment-with-author", "get-blog-post-with-author"})
     * * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"get","collection-get", "post", "get-comment-with-author"})
     * 
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put","collection-get", "post", "get-comment-with-author", "get-blog-post-with-author"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post"})
     * 
     */
    private $email;

     /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "post", "get-comment-with-author"})
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Poster", mappedBy="author", orphanRemoval=true)
     * @Groups({"get","get-image"})
     */
    private $posters;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="author", orphanRemoval=true)
     * @Groups({""})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Faculty", inversedBy="users")
     * @Groups({"get-faculty","post"})
     */
    private $faculty;

    public function __construct()
    {
        $this->posters = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->roles = self::DEFAULT_ROLES;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Poster[]
     */
    public function getPosters(): Collection
    {
        return $this->posters;
    }

    public function addPoster(Poster $poster): self
    {
        if (!$this->posters->contains($poster)) {
            $this->posters[] = $poster;
            $poster->setUser($this);
        }

        return $this;
    }

    public function removePoster(Poster $poster): self
    {
        if ($this->posters->contains($poster)) {
            $this->posters->removeElement($poster);
            // set the owning side to null (unless already changed)
            if ($poster->getUser() === $this) {
                $poster->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFaculty(): ?Faculty
    {
        return $this->faculty;
    }

    public function setFaculty(?Faculty $faculty): self
    {
        $this->faculty = $faculty;

        return $this;
    }
    
    //for UserInterface
    
    private $roles;
    
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }
    
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }
}
