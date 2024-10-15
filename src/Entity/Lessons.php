<?php

namespace App\Entity;

use App\Repository\LessonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LessonsRepository::class)
 */
class Lessons
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lessons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contactInformation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $availableDates;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="studentsLessons")
     */
    private $lessonsStudents;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $location;

    public function __construct()
    {
        $this->lessonsStudents = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTeacherId(): ?User
    {
        return $this->teacher_id;
    }

    public function setTeacherId(?User $teacher_id): self
    {
        $this->teacher_id = $teacher_id;

        return $this;
    }

    public function getContactInformation(): ?string
    {
        return $this->contactInformation;
    }

    public function setContactInformation(?string $contactInformation): self
    {
        $this->contactInformation = $contactInformation;

        return $this;
    }

    public function getAvailableDates(): ?string
    {
        return $this->availableDates;
    }

    public function setAvailableDates(?string $availableDates): self
    {
        $this->availableDates = $availableDates;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLessonsStudents(): Collection
    {
        return $this->lessonsStudents;
    }

    public function addLessonsStudent(User $lessonsStudent): self
    {
        if (!$this->lessonsStudents->contains($lessonsStudent)) {
            $this->lessonsStudents[] = $lessonsStudent;
        }

        return $this;
    }

    public function removeLessonsStudent(User $lessonsStudent): self
    {
        $this->lessonsStudents->removeElement($lessonsStudent);

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    
}
