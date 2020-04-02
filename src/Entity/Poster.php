<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      attributes={
 *         "order"={"id": "ASC"},
 *         "formats"={"json", "jsonld", "form"={"multipart/form-data"}}
 *      },
 *      normalizationContext={"groups"={"poster"}},
 *      denormalizationContext={
 *         "groups"={"post"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PosterRepository")
 */
class Poster
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("poster")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("poster")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("poster")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("poster")
     */
    private $published_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posters")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("poster")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="posters")
     * @Groups("poster")
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="poster", orphanRemoval=true)
     * @Groups("poster")
     */
    private $comments;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("poster")
     */
    private $cost;

    /**
     * @ORM\Column(type="integer")
     * @Groups("poster")
     */
    private $rating = 0;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Image")
     * @ORM\JoinTable()
     * @ApiSubresource()
     * @Groups({"poster"})
    */
    private $images;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->published_at;
    }

    public function setPublishedAt(\DateTimeInterface $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

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
            $comment->setPoster($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getPoster() === $this) {
                $comment->setPoster(null);
            }
        }

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(?int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }
    
    public function incrementRating():self
    {
        $this->rating= $this->rating+1;

        return $this;
    }

    public function decrementRating():self
    {
        $this->rating= $this->rating-1;

        return $this;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
    
    public function getImages(): Collection
    {
        return $this->images;
    }
    
    public function addImage(Image $image)
    {
        $this->images->add($image);
    }
    
    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }
}
