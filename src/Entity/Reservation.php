<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $placeNumber = null;

    #[ORM\Column]
    private ?float $totalPrice = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userReservation = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Concert $concert = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaceNumber(): ?int
    {
        return $this->placeNumber;
    }

    public function setPlaceNumber(int $placeNumber): self
    {
        $this->placeNumber = $placeNumber;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getUserReservation(): ?User
    {
        return $this->userReservation;
    }

    public function setUserReservation(?User $userReservation): self
    {
        $this->userReservation = $userReservation;

        return $this;
    }

    public function getConcert(): ?Concert
    {
        return $this->concert;
    }

    public function setConcert(?Concert $concert): self
    {
        $this->concert = $concert;

        return $this;
    }
}
