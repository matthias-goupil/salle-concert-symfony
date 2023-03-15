<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_MATTHIAS = "User Matthias";
    public const USER_MEHDI= "User Mehdi";
    public const USER_ALLAN = "User Allan";

    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setEmail("matthias.goupil@smile.fr")
            ->setPassword("test")
            ->setFirstname("Matthias")
            ->setLastname("Goupil")
            ->setRoles(['ADMIN']);
//            ->addReservation($this->getReference(ReservationFixtures::RESERVATION_USER1_1))
//            ->addReservation($this->getReference(ReservationFixtures::RESERVATION_USER1_2))
//            ->addOpinion($this->getReference(OpinionFixtures::OPINION_USER1_1))
//            ->addOpinion($this->getReference(OpinionFixtures::OPINION_USER1_2));

        $user2 = (new User())
            ->setEmail("mehdi.sahari@smile.fr")
            ->setPassword("test")
            ->setFirstname("Mehdi")
            ->setLastname("Sahari");
//            ->addReservation($this->getReference(ReservationFixtures::RESERVATION_USER2_1))
//            ->addOpinion($this->getReference(OpinionFixtures::OPINION_USER2_1));

        $user3 = (new User())
            ->setEmail("allan.mantagné@etu.umontpellier.fr")
            ->setPassword("test")
            ->setFirstname("Allan")
            ->setLastname("Montagné");
//            ->addReservation($this->getReference(ReservationFixtures::RESERVATION_USER1_3));

        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->flush();

        $this->addReference(self::USER_MATTHIAS, $user);
        $this->addReference(self::USER_MEHDI, $user2);
        $this->addReference(self::USER_ALLAN, $user3);

    }
    public function getOrder(): int
    {
        return 6;
    }
}
