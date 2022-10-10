<?php

namespace App\Form;

use App\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('name', null, [ 
            'label' => 'Nom',
           
             ])

        ->add('phone_number', null, 
            [ 'label' => 'Numéro de téléphone',
           ])


        ->add('email', EmailType::class, [
           
        ])


        ->add('website', null,
            [ 'label' => 'Site Web',
            
           ])

        ->add('siret_number', NumberType::class,
            [ 'label' => 'Numéro de Siret',
            ])

        ->add('picture', FileType::class,
            [ 'label' => 'Image', 
            ])

        ->add('description', null, [
           
        ])

        ->add('road_specificity', null,
            [ 'label' => 'Indication routière',
            ])


        ->add('addresses',  CollectionType::class,[
            'data_class' => null,
            'label'=> false,
            'entry_type' => AddressType::class,
            'entry_options' =>['label'=> 'Adresse'],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            
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
