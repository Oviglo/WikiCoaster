<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Coaster;
use App\Entity\Park;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoasterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: [
                'label' => 'Nom du coaster',
            ])
            ->add('maxSpeed', options: [
                'label' => 'Vitesse maximum',
                'help' => 'en Km/h',
            ])
            ->add('length')
            ->add('maxHeight')
            ->add('operating')
            ->add('park', EntityType::class, [
                'class' => Park::class,
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'required' => false,
                'expanded' => true,
                'query_builder' => function(EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c')
                        // ->where('c.public = true')
                        ->orderBy('c.name', 'ASC')
                    ;
                }
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coaster::class,
        ]);
    }
}
