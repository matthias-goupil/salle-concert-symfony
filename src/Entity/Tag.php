<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: MusicGroup::class, inversedBy: 'tags')]
    private Collection $musicGroups;

    public function __construct()
    {
        $this->musicGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, MusicGroup>
     */
    public function getMusicGroups(): Collection
    {
        return $this->musicGroups;
    }

    public function addMusicGroup(MusicGroup $musicGroup): self
    {
        if (!$this->musicGroups->contains($musicGroup)) {
            $this->musicGroups->add($musicGroup);
        }

        return $this;
    }

    public function removeMusicGroup(MusicGroup $musicGroup): self
    {
        $this->musicGroups->removeElement($musicGroup);

        return $this;
    }
}
