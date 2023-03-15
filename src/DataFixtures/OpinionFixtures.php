<?php

namespace App\DataFixtures;

use App\Entity\Opinion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OpinionFixtures extends Fixture implements DependentFixtureInterface
{
    public const OPINION_USER1_1 = "Opinion 1 user 1";
    public const OPINION_USER1_2 = "Opinion 2 user 1";
    public const OPINION_USER2_1 = "Opinion 1 user 2";

    public function load(ObjectManager $manager): void
    {
        ($opinion = new Opinion())
            ->setComment("Trop bien !")
            ->setNote(5)
            ->setConcert($this->getReference(ConcertFixtures::CONCERT_BIGFLO_ET_OLI))
            ->setUserOpinon($this->getReference(UserFixtures::USER_MATTHIAS));

        $manager->persist($opinion);

        $this->addReference(self::OPINION_USER1_1,$opinion);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ConcertFixtures::class
        ];
    }
}
