<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailRepository")
 */
class Email
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
    private $email_address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usertype", inversedBy="emails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_type;

    public function getId()
    {
        return $this->id;
    }

    public function getEmailAddress(): ?string
    {
        return $this->email_address;
    }

    public function setEmailAddress(string $email_address): self
    {
        $this->email_address = $email_address;

        return $this;
    }

    public function getUserType(): ?Usertype
    {
        return $this->user_type;
    }

    public function setUserType(?Usertype $user_type): self
    {
        $this->user_type = $user_type;

        return $this;
    }
}
