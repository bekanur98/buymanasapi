<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
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
     */
    private $dep_name_kg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dep_name_ru;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dep_name_en;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dep_name_tr;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Faculty", inversedBy="departments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faculty;

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

    public function getFacultyId(): ?Faculty
    {
        return $this->faculty_id;
    }

    public function setFacultyId(?Faculty $faculty_id): self
    {
        $this->faculty_id = $faculty_id;

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

    public function __toString() {
        return $this->dep_name_en;
    }
}
