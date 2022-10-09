<?php

namespace App\Form;

use App\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                
        ->add('name', null, [
            'data_class' => null,
            'label' => 'Nom'
        ])

        ->add('phone_number', null, [
            'data_class' => null,
            'label' => 'Numéro de téléphone'
        ])

        ->add('email')

        ->add('website', null, [
            'data_class' => null,
            'label' => 'Site Web'
        ])

        ->add('siret_number', null, [
            'data_class' => null,
            'label' => 'Numéro de Siret'
        ])

        ->add('picture', FileType::class, [
            'data_class' => null,
            'label' => 'Image'
        ],
            )

        ->add('description', null,[
            'data_class' => null,
        ])

        ->add('road_specificity', null, [
            'data_class' => null,
            'label' => 'Indication routière'
        ])

        ->add('addresses',  CollectionType::class,[
            'data_class' => null,
            'label'=> false,
            'entry_type' => AddressType::class,
            'entry_options' =>['label'=> 'Adresse'],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false
        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Store::class,
        ]);
    }
}
