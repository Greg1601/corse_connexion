<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime")
     */
    private $begins;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ends;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place;

    public function getId()
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getBegins(): ?\DateTimeInterface
    {
        return $this->begins;
    }

    public function setBegins(\DateTimeInterface $begins): self
    {
        $this->begins = $begins;

        return $this;
    }

    public function getEnds(): ?\DateTimeInterface
    {
        return $this->ends;
    }

    public function setEnds(\DateTimeInterface $ends): self
    {
        $this->ends = $ends;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }
}
