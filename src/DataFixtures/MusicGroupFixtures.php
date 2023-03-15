<?php

namespace App\DataFixtures;

use App\Entity\MusicGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MusicGroupFixtures extends Fixture
{
    public const MUSICGROUP_BIGFLO_ET_OLI = "MusicGroup Bigflo et Oli";
    public const MUSICGROUP_JUL = "MusicGroup Jul";
    public const MUSICGROUP_LOUISE_ATTAQUE = "MusicGroup Louise attaque";

    public function load(ObjectManager $manager): void
    {
        ($musicGroup = new MusicGroup())
            ->setStageName("Bigflo et Oli");

        ($musicGroup2 = new MusicGroup())
            ->setStageName("Jul")
            ->setDescription("Description de Jul");
//            ->addConcert($this->getReference(ConcertFixtures::CONCERT_JUL));


        ($musicGroup3 = new MusicGroup())
            ->setStageName("Lousie attaque");
//            ->addConcert($this->getReference(ConcertFixtures::CONCERT_LOUISE_ATTAQUE));

        $manager->persist($musicGroup);
        $manager->persist($musicGroup2);
        $manager->persist($musicGroup3);

        $manager->flush();

        $this->addReference(self::MUSICGROUP_BIGFLO_ET_OLI,$musicGroup);
        $this->addReference(self::MUSICGROUP_JUL,$musicGroup2);
        $this->addReference(self::MUSICGROUP_LOUISE_ATTAQUE,$musicGroup3);

    }
}
