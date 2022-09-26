<?php

namespace App\Entity;

use App\Repository\StoreHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StoreHoursRepository::class)]
class StoreHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $morning_opening_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $morning_closing_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $afternoon_opening_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $afternoon_closing_time = null;

    #[ORM\ManyToOne(inversedBy: 'storeHours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Store $store = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getMorningOpeningTime(): ?\DateTimeInterface
    {
        return $this->morning_opening_time;
    }

    public function setMorningOpeningTime(?\DateTimeInterface $morning_opening_time): self
    {
        $this->morning_opening_time = $morning_opening_time;

        return $this;
    }

    public function getMorningClosingTime(): ?\DateTimeInterface
    {
        return $this->morning_closing_time;
    }

    public function setMorningClosingTime(?\DateTimeInterface $morning_closing_time): self
    {
        $this->morning_closing_time = $morning_closing_time;

        return $this;
    }

    public function getAfternoonOpeningTime(): ?\DateTimeInterface
    {
        return $this->afternoon_opening_time;
    }

    public function setAfternoonOpeningTime(?\DateTimeInterface $afternoon_opening_time): self
    {
        $this->afternoon_opening_time = $afternoon_opening_time;

        return $this;
    }

    public function getAfternoonClosingTime(): ?\DateTimeInterface
    {
        return $this->afternoon_closing_time;
    }

    public function setAfternoonClosingTime(?\DateTimeInterface $afternoon_closing_time): self
    {
        $this->afternoon_closing_time = $afternoon_closing_time;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }
}
