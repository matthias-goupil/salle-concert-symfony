<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public const RESERVATION_USER1_1 = "Reservation 1 user 1";
    public const RESERVATION_USER1_2 = "Reservation 2 user 1";
    public const RESERVATION_USER2_1 = "Reservation 1 user 2";
    public const RESERVATION_USER3_1 = "Reservation 1 user 3";

    public function load(ObjectManager $manager): void
    {
        ($reservation = new Reservation())
            ->setConcert($this->getReference(ConcertFixtures::CONCERT_LOUISE_ATTAQUE))
            ->setUserReservation($this->getReference(UserFixtures::USER_MATTHIAS))
            ->setPlaceNumber(1)
            ->setTotalPrice(29.99);

        ($reservation2 = new Reservation())
            ->setConcert($this->getReference(ConcertFixtures::CONCERT_BIGFLO_ET_OLI))
            ->setUserReservation($this->getReference(UserFixtures::USER_MATTHIAS))
            ->setPlaceNumber(1)
            ->setTotalPrice(29.99);

        ($reservation3 = new Reservation())
            ->setConcert($this->getReference(ConcertFixtures::CONCERT_JUL))
            ->setUserReservation($this->getReference(UserFixtures::USER_MEHDI))
            ->setPlaceNumber(1)
            ->setTotalPrice(29.99);

        ($reservation4 = new Reservation())
            ->setConcert($this->getReference(ConcertFixtures::CONCERT_JUL))
            ->setUserReservation($this->getReference(UserFixtures::USER_ALLAN))
            ->setPlaceNumber(2)
            ->setTotalPrice(29.99);

        $manager->persist($reservation);
        $manager->persist($reservation2);
        $manager->persist($reservation3);
        $manager->persist($reservation4);

        $manager->flush();

        $this->addReference(self::RESERVATION_USER1_1,$reservation);
        $this->addReference(self::RESERVATION_USER1_2,$reservation2);
        $this->addReference(self::RESERVATION_USER2_1,$reservation3);
        $this->addReference(self::RESERVATION_USER3_1,$reservation4);

    }

    public function getDependencies()
    {
        return [
            ConcertFixtures::class,
            UserFixtures::class,
        ];
    }
}
