<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArtistFixtures extends Fixture implements DependentFixtureInterface
{
    public const ARTIST_JUL = 'jul';
    public const ARTIST_BIGFLO = 'bigflo';
    public const ARTIST_OLI = 'oli';
    public const ARTIST_GAETAN = 'gaetan';

    public function load(ObjectManager $manager): void
    {
        ($artist = new Artist())
            ->setFirstname('Gaëtan')
            ->setLastname('Roussel')
            ->setDescription("Gaëtan Roussel est un auteur-compositeur-interprète et animateur de radio français")
            ->setMusicGroup($this->getReference(MusicGroupFixtures::MUSICGROUP_LOUISE_ATTAQUE));

        ($artist2 = new Artist())
            ->setFirstname('Julien')
            ->setLastname('Mari')
            ->setDescription("Julien Mari dit Jul, stylisé JuL est un rappeur, chanteur et auteur-compositeur-interprète français")
            ->setMusicGroup($this->getReference(MusicGroupFixtures::MUSICGROUP_JUL));


        ($artist3 = new Artist())
            ->setFirstname('Florain')
            ->setLastname('Ordonez')
            ->setDescription("Florian Ordonez dit Bigflo, est un rappeur, chanteur et auteur-compositeur-interprète français faisant partie du groupe de rap Bigflo et Oli")
            ->setMusicGroup($this->getReference(MusicGroupFixtures::MUSICGROUP_BIGFLO_ET_OLI));

        ($artist4 = new Artist())
            ->setFirstname('Olivier')
            ->setLastname('Ordonez')
            ->setDescription("Olivier Ordonez dit Bigflo, est un rappeur, chanteur et auteur-compositeur-interprète français faisant partie du groupe de rap Bigflo et Oli")
            ->setMusicGroup($this->getReference(MusicGroupFixtures::MUSICGROUP_BIGFLO_ET_OLI));

        $manager->persist($artist);
        $manager->persist($artist2);
        $manager->persist($artist3);
        $manager->persist($artist4);

        $manager->flush();

        $this->addReference(self::ARTIST_GAETAN, $artist);
        $this->addReference(self::ARTIST_JUL, $artist2);
        $this->addReference(self::ARTIST_BIGFLO, $artist3);
        $this->addReference(self::ARTIST_OLI, $artist4);
    }
    public function getDependencies()
    {
        return [
            MusicGroupFixtures::class,
        ];
    }
}
