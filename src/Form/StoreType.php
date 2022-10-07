<?php

namespace App\Form;

use App\Entity\Address;
use App\Form\AddressType;
use App\Entity\Store;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                
        ->add('name', null, 
            [ 'label' => 'Nom' ])

        ->add('phone_number', null, 
            [ 'label' => 'Numéro de téléphone' ])

        ->add('email')

        ->add('website', null,
            [ 'label' => 'Site Web'])

        ->add('siret_number', null,
            [ 'label' => 'Numéro de Siret'])

        ->add('picture', FileType::class,
            [ 'label' => 'Image'])

        ->add('description')

        ->add('road_specificity', null,
            [ 'label' => 'Indication routière'])

        ->add('addresses',  CollectionType::class,[
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
