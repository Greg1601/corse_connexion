<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailRepository")
 * @UniqueEntity("email")
 */
class CompanyEmail
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usertype", inversedBy="emails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_type;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     * * @Assert\Email()
     */
    private $address;

    public function getUserType(): ?Usertype
    {
        return $this->user_type;
    }

    public function setUserType(?Usertype $user_type): self
    {
        $this->user_type = $user_type;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }
}
