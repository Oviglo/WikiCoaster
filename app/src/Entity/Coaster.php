<?php

namespace App\Entity;

use App\Repository\CoasterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoasterRepository::class)]
class Coaster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxSpeed = null;

    #[ORM\Column(nullable: true)]
    private ?int $length = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxHeight = null;

    #[ORM\Column]
    private ?bool $operating = true;

    #[ORM\ManyToOne(inversedBy: 'coasters')]
    private ?Park $park = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'coasters')]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getMaxSpeed(): ?int
    {
        return $this->maxSpeed;
    }

    public function setMaxSpeed(?int $maxSpeed): static
    {
        $this->maxSpeed = $maxSpeed;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): static
    {
        $this->length = $length;

        return $this;
    }

    public function getMaxHeight(): ?int
    {
        return $this->maxHeight;
    }

    public function setMaxHeight(?int $maxHeight): static
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    public function isOperating(): ?bool
    {
        return $this->operating;
    }

    public function setOperating(bool $operating): static
    {
        $this->operating = $operating;

        return $this;
    }

    public function getPark(): ?Park
    {
        return $this->park;
    }

    public function setPark(?Park $park): static
    {
        $this->park = $park;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
