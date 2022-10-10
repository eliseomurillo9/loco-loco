<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => false,
                'attr' => [
                    'style' => 'border-radius: 6px; border: 1px solid var(--main-bis); padding: 5px; '
                ]
            ])
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => [
                    'style' => 'border-radius: 6px; border: 1px solid var(--main-bis); padding: 5px; '
                ] 
            ])
            ->add('lastname', null,[
                'label' => false,
                'attr' => [
                    'style' => 'border-radius: 6px; border: 1px solid var(--main-bis); padding: 5px; '
                ],
            ])
            ->add('firstname', null,[
                'label' => false,
                'attr' => [
                    'style' => 'border-radius: 6px; border: 1px solid var(--main-bis); padding: 5px; '
                ],
            ])

            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-main',
                    'style' => 'width: 200px'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
