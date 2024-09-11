<?php

namespace App\Entity;

use App\Repository\LessonsRepository;
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
}
