<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OpportunityRepository")
 */
class Opportunity
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
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="opportunities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\Column(type="text")
     */
    private $contact;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $salary;

    /**
     * @ORM\Column(type="text")
     */
    private $required_expertise;

    /**
     * @ORM\Column(type="text")
     */
    private $place;

    /**
     * @ORM\Column(type="boolean")
     */
    private $remote_possibility;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="opportunities")
     */
    private $skills_required;

    public function __construct()
    {
        $this->skills_required = new ArrayCollection();
    }

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCompany(): ?company
    {
        return $this->company;
    }

    public function setCompany(?company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(?string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getRequiredExpertise(): ?string
    {
        return $this->required_expertise;
    }

    public function setRequiredExpertise(string $required_expertise): self
    {
        $this->required_expertise = $required_expertise;

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

    public function getRemotePossibility(): ?bool
    {
        return $this->remote_possibility;
    }

    public function setRemotePossibility(bool $remote_possibility): self
    {
        $this->remote_possibility = $remote_possibility;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkillsRequired(): Collection
    {
        return $this->skills_required;
    }

    public function addSkillsRequired(Skill $skillsRequired): self
    {
        if (!$this->skills_required->contains($skillsRequired)) {
            $this->skills_required[] = $skillsRequired;
        }

        return $this;
    }

    public function removeSkillsRequired(Skill $skillsRequired): self
    {
        if ($this->skills_required->contains($skillsRequired)) {
            $this->skills_required->removeElement($skillsRequired);
        }

        return $this;
    }
}
