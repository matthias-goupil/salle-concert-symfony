<?php

namespace App\Form;

use App\Entity\Concert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $musicGroups = [];
        $concertHalls = [];
        foreach ($options["musicGroups"] as $musicGroup) {
            $musicGroups[$musicGroup->getStageName()] = $musicGroup->getId();
        }

        foreach ($options["concertHalls"] as $concertHall) {
            $concertHalls[$concertHall->getAdress()] = $concertHall->getId();
        }

        $builder
            ->add('musicGroup', ChoiceType::class, [
                "choices" => $musicGroups,
                "mapped" => false,
                "data" => $builder->getData()->getMusicGroup()?->getId()
            ])
            ->add('description', TextareaType::class)
            ->add('date')
            ->add('duration', NumberType::class)
            ->add('price',NumberType::class)
            ->add('placeNumberAvailable', NumberType::class)
            ->add('concertHall', ChoiceType::class, [
                "choices" => $concertHalls,
                "mapped" => false,
                "data" => $builder->getData()->getConcertHall()?->getId()
            ])
            ->add('picture', FileType::class,[
                "mapped" => false,
                "required" => false
            ]);

//        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Concert::class,
            'musicGroups' => [],
            'concertHalls' => []
        ]);
    }
}
