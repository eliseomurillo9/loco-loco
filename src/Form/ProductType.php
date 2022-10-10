<?php

namespace App\Form;

use App\Entity\Store;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'nom du produit'
            ])
            ->add('is_available', null, [
                'label' => 'Disponible',
                'attr'=>[

                ]
            ])
            ->add('price', null, [
                'label' => 'Prix'
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image du produit',
            ])
            ->add('description',null,[
                'attr'=>[
        'rows' => 5,
        'placeholder' => 'variété, conditionnement, aspect, saveur ...'
    ],])
            ->add('category')
            ->add('stores', EntityType::class, [
                'class' => Store::class,
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('s')
                    ->andWhere('s.owner = :val')
                    ->setParameter('val', $options['user']);
                },
                'choice_label' => 'name',
            ])
        ->add('valider', SubmitType::class, [
            'label' => 'Valider',
            'attr' => [
            'class' => 'btn-second',
            'style' => 'width: 200px'
                    ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'user' => null,
        ]);
    }
}
