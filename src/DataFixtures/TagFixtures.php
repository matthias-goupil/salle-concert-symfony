<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ($tag = new Tag())
            ->setName("Rap")
            ->addMusicGroup($this->getReference(MusicGroupFixtures::MUSICGROUP_BIGFLO_ET_OLI))
            ->addMusicGroup($this->getReference(MusicGroupFixtures::MUSICGROUP_JUL));
        ($tag1 = new Tag())
            ->setName("Pop rock")
            ->addMusicGroup($this->getReference(MusicGroupFixtures::MUSICGROUP_LOUISE_ATTAQUE));


        $manager->persist($tag);
        $manager->persist($tag1);

        $manager->flush();
    }
}
