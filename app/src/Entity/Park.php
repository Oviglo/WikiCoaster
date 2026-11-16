<?php

namespace App\Entity;

use App\Repository\ParkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParkRepository::class)]
class Park
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $name = null;

    #[ORM\Column(length: 2)]
    private ?string $country = null;

    #[ORM\Column(nullable: true)]
    private ?int $openingYear = null;

    /**
     * @var Collection<int, Coaster>
     */
    #[ORM\OneToMany(targetEntity: Coaster::class, mappedBy: 'park')]
    private Collection $coasters;

    public function __construct()
    {
        $this->coasters = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getOpeningYear(): ?int
    {
        return $this->openingYear;
    }

    public function setOpeningYear(?int $openingYear): static
    {
        $this->openingYear = $openingYear;

        return $this;
    }

    /**
     * @return Collection<int, Coaster>
     */
    public function getCoasters(): Collection
    {
        return $this->coasters;
    }

    public function addCoaster(Coaster $coaster): static
    {
        if (!$this->coasters->contains($coaster)) {
            $this->coasters->add($coaster);
            $coaster->setPark($this);
        }

        return $this;
    }

    public function removeCoaster(Coaster $coaster): static
    {
        if ($this->coasters->removeElement($coaster)) {
            // set the owning side to null (unless already changed)
            if ($coaster->getPark() === $this) {
                $coaster->setPark(null);
            }
        }

        return $this;
    }
}
