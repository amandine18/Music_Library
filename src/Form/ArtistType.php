<?php

namespace App\Form;

use App\Entity\Artist;
// use App\Entity\Track;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Artist Name',
                'attr' => [
                    'placeholder' => 'Choose an artist name',
                ]
            ])
            ->add('thumbnailurl', UrlType::class, [
                'label' => 'Thumbnail URL',
                'attr' => [
                    'placeholder' => 'Enter a thumbnail URL',
                ]
            ])
            // ->add('featuredIn', EntityType::class, [
            //     'class' => Track::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
