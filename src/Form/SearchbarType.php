<?php

namespace App\Form;

use App\Data\SearchBar;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SearchbarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('category', EntityType::class, [
            'label' => false,
            'required' => false,
            'class' => Category::class,
        ])
        ->add('location', TextareaType::class, [
            'label' => 'On tas?',
        ])
        ->add('range', ChoiceType::class, [
            'label' => 'Cuanto remas?',
            'choices' => [
                '5' => 5,
                '10' => 10,
                '15' => 15,
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
    }
}
