<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $musicGroups = [];
        foreach ($options["musicGroups"] as $musicGroup) {
            $musicGroups[$musicGroup->getStageName()] = $musicGroup->getId();
        }
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('picture', FileType::class,[
                "mapped" => false,
                "required" => false
            ])
            ->add('description', TextareaType::class)
            ->add('musicGroup', ChoiceType::class, [
                "choices" => $musicGroups,
                "mapped" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
            'musicGroups' => []
        ]);
    }
}
