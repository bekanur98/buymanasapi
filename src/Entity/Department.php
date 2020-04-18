<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * * @ApiResource(
 *      attributes={
 *         "order"={"id": "ASC"},
 *         "formats"={"json", "jsonld", "form"={"multipart/form-data"}},"maximum_items_per_page"=30, "enable_max_depth"=true
 *      },
 *     itemOperations={
 *         "get"={
 *             "normalization_context"={
 *                 "groups"={"get-blog-post-with-author"}
 *             }
 *          },
 *         "put"
 *     },
 *      collectionOperations={
 *          "get",
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
 *     denormalizationContext={
 *         "groups"={"post"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 */
class Department
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get"})
     */
    public $dep_name_kg;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get"})
     */
    public $dep_name_ru;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({""})
     */
    public $dep_name_en;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({""})
     */
    public $dep_name_tr;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Faculty", inversedBy="departments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-blog-post-with-dp","faculty"})
     */
    private $faculty;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Poster", mappedBy="department")
     * @Groups({"get"})
     */
    private $posters;

    public function __construct()
    {
        $this->posters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepNameKg(): ?string
    {
        return $this->dep_name_kg;
    }

    public function setDepNameKg(string $dep_name_kg): self
    {
        $this->dep_name_kg = $dep_name_kg;

        return $this;
    }

    public function getDepNameRu(): ?string
    {
        return $this->dep_name_ru;
    }

    public function setDepNameRu(string $dep_name_ru): self
    {
        $this->dep_name_ru = $dep_name_ru;

        return $this;
    }

    public function getDepNameEn(): ?string
    {
        return $this->dep_name_en;
    }

    public function setDepNameEn(string $dep_name_en): self
    {
        $this->dep_name_en = $dep_name_en;

        return $this;
    }

    public function getDepNameTr(): ?string
    {
        return $this->dep_name_tr;
    }

    public function setDepNameTr(string $dep_name_tr): self
    {
        $this->dep_name_tr = $dep_name_tr;

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

    public function __toString()
    {
        return $this->getDepNameRu();
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
            $poster->setDepartment($this);
        }

        return $this;
    }

    public function removePoster(Poster $poster): self
    {
        if ($this->posters->contains($poster)) {
            $this->posters->removeElement($poster);
            // set the owning side to null (unless already changed)
            if ($poster->getDepartment() === $this) {
                $poster->setDepartment(null);
            }
        }

        return $this;

    }
}
