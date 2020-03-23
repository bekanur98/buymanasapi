<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FacultyRepository")
 */
class Faculty
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
    private $faculty_name_kg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $faculty_name_ru;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $faculty_name_en;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $faculty_name_tr;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Department", mappedBy="faculty", orphanRemoval=true)
     */
    private $departments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="faculty")
     */
    private $users;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFacultyNameKg(): ?string
    {
        return $this->faculty_name_kg;
    }

    public function setFacultyNameKg(string $faculty_name_kg): self
    {
        $this->faculty_name_kg = $faculty_name_kg;

        return $this;
    }

    public function getFacultyNameRu(): ?string
    {
        return $this->faculty_name_ru;
    }

    public function setFacultyNameRu(string $faculty_name_ru): self
    {
        $this->faculty_name_ru = $faculty_name_ru;

        return $this;
    }

    public function getFacultyNameEn(): ?string
    {
        return $this->faculty_name_en;
    }

    public function setFacultyNameEn(string $faculty_name_en): self
    {
        $this->faculty_name_en = $faculty_name_en;

        return $this;
    }

    public function getFacultyNameTr(): ?string
    {
        return $this->faculty_name_tr;
    }

    public function setFacultyNameTr(string $faculty_name_tr): self
    {
        $this->faculty_name_tr = $faculty_name_tr;

        return $this;
    }

    /**
     * @return Collection|Department[]
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments[] = $department;
            $department->setFaculty($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        if ($this->departments->contains($department)) {
            $this->departments->removeElement($department);
            // set the owning side to null (unless already changed)
            if ($department->getFaculty() === $this) {
                $department->setFaculty(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->faculty_name_en;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setFaculty($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getFaculty() === $this) {
                $user->setFaculty(null);
            }
        }

        return $this;
    }
}
