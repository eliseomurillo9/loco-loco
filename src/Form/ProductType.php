<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Store;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('is_available')
            ->add('price')
            ->add('picture')
            ->add('description')
            ->add('category')
            ->add('stores', EntityType::class, [
            'label' => 'Mes Magasins',
                    'class' => user::class,
                    'mapped' => false,
                'choice_label' => function ($user) {
                    return $user->getOwnedStores();
                }
                ],
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
