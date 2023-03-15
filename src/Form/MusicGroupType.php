<?php

namespace App\Form;

use App\Entity\MusicGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MusicGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $tags = [];
        foreach ($options["tags"] as $tag) {
            $tags[$tag->getName()] = $tag->getId();
        }
        $builder
            ->add('stageName', TextType::class, [
                "label" => "Nom de scène"
            ])
            ->add('description', TextareaType::class,
                [
                    "label" => "Description du groupe"
                ])
            ->add('picture', FileType::class, [
                "label" => "Image du groupe",
                "mapped"=> false,
                "required" => false,
            ])
            ->add('tags', ChoiceType::class, [
                "label" => "Styles musicaux",
                "multiple" => true,
                "choices" => $tags,
                "required" => false,
//                "data" => array_map(function($tag){ return $tag->getId();},$builder->getData()->getTags()),
                "mapped" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MusicGroup::class,
            'tags' => []
        ]);
    }
}
