<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SearchbarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->setAction('/store/locator')
        ->setMethod('GET')
        ->add('category', EntityType::class, [
            'label' => false,
            'placeholder' => 'Categorie',
            'required' => false,
            'class' => Category::class,
        ])
        ->add('location', TextType::class, [
            'label' => 'Où suis je ?',
            'required' => false,
            

        ])
        ->add('range', ChoiceType::class, [
            'placeholder' => 'Dans un rayons de :',
            'label' => false,
            'choices' => [
                '5 km' => 5,
                '10 km' => 10,
                '15 km' => 15,
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
    }
}
