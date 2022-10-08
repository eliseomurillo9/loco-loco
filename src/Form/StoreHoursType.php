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
            ->add('day', null ,[
                'label'=> 'Lundi',
            ])
            ->add('morning_opening_time', null,[
                'label'=> 'horaire d\'ouverture du matin'])
            ->add('morning_closing_time', null,[
                'label'=> 'horaire de fermeture du matin'])
            ->add('afternoon_opening_time', null,[
                'label'=> 'horaire d\'ouverture de l\'après-midi'])
            ->add('afternoon_closing_time', null,[
                'label'=> 'horaire de fermeture de l\'après-midi'])

            ->add('day', null, [
                'label'=> 'Mardi',
            ])
            ->add('morning_opening_time', null,[
                'label'=> 'horaire d\'ouverture du matin'])
            ->add('morning_closing_time', null,[
                'label'=> 'horaire de fermeture du matin'])
            ->add('afternoon_opening_time', null,[
                'label'=> 'horaire d\'ouverture de l\'après-midi'])
            ->add('afternoon_closing_time', null,[
                'label'=> 'horaire de fermeture de l\'après-midi'])

            ->add('day', null, [
                'label'=> 'Mercredi',
            ])
            ->add('morning_opening_time', null,[
                'label'=> 'horaire d\'ouverture du matin'])
            ->add('morning_closing_time', null,[
                'label'=> 'horaire de fermeture du matin'])
            ->add('afternoon_opening_time', null,[
                'label'=> 'horaire d\'ouverture de l\'après-midi'])
            ->add('afternoon_closing_time', null,[
                'label'=> 'horaire de fermeture de l\'après-midi'])

            ->add('day', null, [
                'label'=> 'Jeudi',
            ])
            ->add('morning_opening_time', null,[
            'label'=> 'horaire d\'ouverture du matin'])
            ->add('morning_closing_time', null,[
                'label'=> 'horaire de fermeture du matin'])
            ->add('afternoon_opening_time', null,[
                'label'=> 'horaire d\'ouverture de l\'après-midi'])
            ->add('afternoon_closing_time', null,[
                'label'=> 'horaire de fermeture de l\'après-midi'])

            ->add('day', null,[
                'label'=> 'Vendredi',
            ])
            ->add('morning_opening_time', null,[
                'label'=> 'horaire d\'ouverture du matin'])
            ->add('morning_closing_time', null,[
                'label'=> 'horaire de fermeture du matin'])
            ->add('afternoon_opening_time', null,[
                'label'=> 'horaire d\'ouverture de l\'après-midi'])
            ->add('afternoon_closing_time', null,[
                'label'=> 'horaire de fermeture de l\'après-midi'])

            ->add('day', null ,[
                'label'=> 'Samedi',
            ])
            ->add('morning_opening_time', null,[
                'label'=> 'horaire d\'ouverture du matin'])
            ->add('morning_closing_time', null,[
                'label'=> 'horaire de fermeture du matin'])
            ->add('afternoon_opening_time', null,[
                'label'=> 'horaire d\'ouverture de l\'après-midi'])
            ->add('afternoon_closing_time', null,[
                'label'=> 'horaire de fermeture de l\'après-midi'])

            ->add('day', null ,[
                'label'=> 'Dimanche',
            ])
            ->add('morning_opening_time', null,[
                'label'=> 'horaire d\'ouverture du matin'])
            ->add('morning_closing_time', null,[
                'label'=> 'horaire de fermeture du matin'])
            ->add('afternoon_opening_time', null,[
                'label'=> 'horaire d\'ouverture de l\'après-midi'])
            ->add('afternoon_closing_time', null,[
                'label'=> 'horaire de fermeture de l\'après-midi'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StoreHours::class,
        ]);
    }
}
