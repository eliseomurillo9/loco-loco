<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Store;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('category');

            $storeChoices = [];
        foreach ($options['stores'] as $store) {
            $storeChoices[] = [$store->getName => $store->getId()];
            return $storeChoices
        };
            ->add('stores', ChoiceType::class,[
                    'required' => false,
                    'multiple' => true,
                    'choices' => $options['stores']
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
                // ...,
                'stores' => [],
            ]);

        // you can also define the allowed types, allowed values and
        // any other feature supported by the OptionsResolver component
        $resolver->setAllowedTypes('stores', 'array');

    }
}
