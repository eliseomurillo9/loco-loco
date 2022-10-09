<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EditProductType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('is_available', CheckboxType::class, [
                'data_class' => null,
                'label' => 'Disponible',
                'attr' => [],
            ])
            ->add('price', TextType::class, [
                'data_class' => null,
                'label' => 'Prix',
            ])
            ->add('picture', FileType::class, [
                'data_class' => null,
                'label' => 'Image du produit',
            ])
            ->add('description', TextType::class, [
                'data_class' => null,
                'attr' => [
                    'rows' => 5,
                    'placeholder' =>
                        'variété, conditionnement, aspect, saveur ...',
                ],
            ])
            ->add('valider', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn-second',
                    'style' => 'width: 200px',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
