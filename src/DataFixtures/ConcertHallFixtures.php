<?php

namespace App\DataFixtures;

use App\Entity\Concert;
use App\Entity\ConcertHall;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConcertHallFixtures extends Fixture
{
    public const CONCERTHALL_MONTPELLIER = "ConcertHall Montpellier";
    public const CONCERTHALL_TOULOUSE = "ConcertHall Toulouse";

    public function load(ObjectManager $manager): void
    {
        ($concertHall = new ConcertHall())
            ->setDescription("Description de la salle de concert")
            ->setAdress("5 avenue de breteuil, Toulouse, 31555");
//            ->addConcert($this->getReference(ConcertFixtures::CONCERT_BIGFLO_ET_OLI));

        ($concertHall2 = new ConcertHall())
            ->setDescription("Description de la salle de concert")
            ->setAdress("99 avenue d'occitanie, Montpellier 34090");
//            ->addConcert($this->getReference(ConcertFixtures::CONCERT_LOUISE_ATTAQUE))
//            ->addConcert($this->getReference(ConcertFixtures::CONCERT_JUL));


        $manager->persist($concertHall);
        $manager->persist($concertHall2);

        $manager->flush();

        $this->addReference(self::CONCERTHALL_MONTPELLIER, $concertHall);
        $this->addReference(self::CONCERTHALL_TOULOUSE, $concertHall2);
    }
    public function getOrder(): int
    {
        return 4;
    }
}
