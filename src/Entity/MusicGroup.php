<?php

namespace App\Entity;

use App\Repository\MusicGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicGroupRepository::class)]
class MusicGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $stageName = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 2083, nullable: true)]
    private ?string $picture = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'musicGroup')]
    private Collection $tags;

    #[ORM\OneToMany(mappedBy: 'musicGroup', targetEntity: Concert::class, orphanRemoval: true)]
    private Collection $concerts;

    #[ORM\OneToMany(mappedBy: 'musicGroup', targetEntity: Artist::class, orphanRemoval: true)]
    private Collection $artists;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'likedMusicGroups')]
    private Collection $users;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->concerts = new ArrayCollection();
        $this->artists = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStageName(): ?string
    {
        return $this->stageName;
    }

    public function setStageName(string $stageName): self
    {
        $this->stageName = $stageName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
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

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addMusicGroup($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeMusicGroup($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Concert>
     */
    public function getConcerts(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): self
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts->add($concert);
            $concert->setMusicGroup($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): self
    {
        if ($this->concerts->removeElement($concert)) {
            // set the owning side to null (unless already changed)
            if ($concert->getMusicGroup() === $this) {
                $concert->setMusicGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Artist>
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->artists->contains($artist)) {
            $this->artists->add($artist);
            $artist->setMusicGroup($this);
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        if ($this->artists->removeElement($artist)) {
            // set the owning side to null (unless already changed)
            if ($artist->getMusicGroup() === $this) {
                $artist->setMusicGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addLikedMusicGroup($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeLikedMusicGroup($this);
        }

        return $this;
    }
}
