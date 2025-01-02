<?php

namespace App\Form;

use App\Entity\Release;
use App\Entity\Track;
use App\Repository\ArtistRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrackType extends AbstractType
{
    public function __construct(
        private ArtistRepository $artistRepository,
        private Security $security,
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        $artists = $this->artistRepository->findBy(['owner' => $user]);
        $releases = array_merge(
            array_map(fn ($artist) => $artist->getReleases()->toArray(), $artists)
        );
        $isReleaseDisabled = false;
        
        if ($options['track'] !== null && $options['track']->getRelease() !== null) {
            $isReleaseDisabled = true;
        }

        $builder
            ->add('title')
            ->add('duration')
            ->add('release', EntityType::class, [
                'class' => Release::class,
                'choice_label' => 'title',
                'choices' => $releases[0],
                'disabled' => $isReleaseDisabled,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Track::class,
            'track' => null,
        ]);
    }
}
