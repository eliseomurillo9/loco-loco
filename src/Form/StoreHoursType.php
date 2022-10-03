<?php

namespace App\Form;

use App\Entity\StoreHours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreHoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day')
            ->add('morning_opening_time')
            ->add('morning_closing_time')
            ->add('afternoon_opening_time')
            ->add('afternoon_closing_time')
            ->add('store')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StoreHours::class,
        ]);
    }
}
