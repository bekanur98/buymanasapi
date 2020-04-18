<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * 
 * @ApiFilter(
 *     DateFilter::class,
 *     properties={
 *         "publishedAt"
 *     }
 * )
 * @ApiResource(
 *      attributes={
 *         "order"={"id": "ASC"},
 *         "formats"={"json", "jsonld", "form"={"multipart/form-data"}},"maximum_items_per_page"=30, "enable_max_depth"=true
 *      },
 *      itemOperations={
 *         "get"={
 *             "normalization_context"={
 *                 "groups"={"get-item-image","get-blog-post-with-author","get-blog-post-with-dp","get-comment-with-author"}
 *             }
 *          },
 *         "put",
 *          "delete"
 *     },
 *     collectionOperations={
 *         "get"={
 *             "normalization_context"={
 *                 "groups"={"get-blog-post-with-author","get-blog-post-with-dp","get-blog-post-with-comment"}
 *             }
 *          },
 *         "post",
 *     },
 *     denormalizationContext={
 *         "groups"={"post"}
 *     }
 * )
 * * @ApiFilter(SearchFilter::class, properties={"title": "ipartial"})
 * @ORM\Entity(repositoryClass="App\Repository\PosterRepository")
 */
class Poster implements AuthoredEntityInterface, PublishedDateEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get","get-blog-post-with-author"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get","post", "get-blog-post-with-author"})
     */
    private $title;

//    @ApiFilter(SearchFilter::class, strategy="partial")

    /**
     * @ORM\Column(type="text")
     * @Groups({"get","post", "get-blog-post-with-author"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get","get-blog-post-with-author","post"})
     */
    private $publishedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posters")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-blog-post-with-author", "post"})
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="posters")
     * @Groups({"get-blog-post-with-author","get-blog-post-with-dp","post"})
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="poster", orphanRemoval=true)
     * @ApiSubresource()
     * @Groups({"get-blog-post-with-author","get-blog-post-with-comment","get-comment-with-author"})
     */
    private $comments;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"post", "get-blog-post-with-author"})
     */
    private $cost;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"post", "get-blog-post-with-author"})
     */
    private $rating = 0;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Image")
     * @ORM\JoinTable()
     * @ApiSubresource()
     * @Groups({"post", "get-blog-post-with-author","get-image","get-item-image"})
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
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): PublishedDateEntityInterface
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }
    
    /**
     * @param UserInterface $author
     */
    public function setAuthor(UserInterface $author): AuthoredEntityInterface
    {
        $this->author = $author;

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
