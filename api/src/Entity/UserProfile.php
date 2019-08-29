<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProfileRepository")
 */
class UserProfile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="userProfile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default":0})
     */
    private $baseDistanceMeters = 0;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getBaseDistanceMeters(): int
    {
        return $this->baseDistanceMeters;
    }

    /**
     * @param int $baseDistanceMeters
     *
     * @return static
     */
    public function setBaseDistanceMeters(int $baseDistanceMeters): self
    {
        $this->baseDistanceMeters = $baseDistanceMeters;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return static
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
