<?php

namespace App\DataFixtures;

use App\Entity\Concert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConcertFixtures extends Fixture implements DependentFixtureInterface
{
    public const CONCERT_LOUISE_ATTAQUE = "concert louise attaque";
    public const CONCERT_JUL = "concert jul";
    public const CONCERT_BIGFLO_ET_OLI = "concert bigflo et oli";

    public function load(ObjectManager $manager): void
    {
        ($concert = new Concert())
            ->setDescription("Description du concert de Jul")
            ->setDate( new \DateTime('now'))
            ->setPrice(29.99)
            ->setDuration(2)
            ->setPlaceNumberAvailable(500)
            ->setConcertHall($this->getReference(ConcertHallFixtures::CONCERTHALL_MONTPELLIER))
            ->setMusicGroup($this->getReference(MusicGroupFixtures::MUSICGROUP_JUL));

        ($concert2 = new Concert())
            ->setDescription("Description du concert de Louise attaque")
            ->setDate( new \DateTime('now'))
            ->setPrice(29.99)
            ->setDuration(2.5)
            ->setPlaceNumberAvailable(500)
            ->setConcertHall($this->getReference(ConcertHallFixtures::CONCERTHALL_MONTPELLIER))
            ->setMusicGroup($this->getReference(MusicGroupFixtures::MUSICGROUP_LOUISE_ATTAQUE));


        ($concert3 = new Concert())
            ->setDescription("Description du concert de BigFlo et Oli")
            ->setDate( new \DateTime('now'))
            ->setPrice(29.99)
            ->setDuration(3)
            ->setPlaceNumberAvailable(500)
            ->setConcertHall($this->getReference(ConcertHallFixtures::CONCERTHALL_TOULOUSE))
            ->setMusicGroup($this->getReference(MusicGroupFixtures::MUSICGROUP_BIGFLO_ET_OLI));

        $manager->persist($concert);
        $manager->persist($concert2);
        $manager->persist($concert3);

        $manager->flush();

        $this->addReference(self::CONCERT_JUL, $concert);
        $this->addReference(self::CONCERT_LOUISE_ATTAQUE, $concert2);
        $this->addReference(self::CONCERT_BIGFLO_ET_OLI, $concert3);
    }
    public function getDependencies()
    {
        return [
            ConcertHallFixtures::class,
        ];
    }
}
