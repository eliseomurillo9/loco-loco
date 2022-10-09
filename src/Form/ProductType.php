<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Store;
use App\Entity\Product;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\AsciiStringType;
use Doctrine\DBAL\Types\BinaryType;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'nom du produit'
            ])
            ->add('is_available', null, [
                'label' => 'Disponible',
                'attr'=>[

                ]
            ])
            ->add('price', null, [
                'label' => 'Prix'
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image du produit'
            ])
            ->add('description',null,[
                'attr'=>[
        'rows' => 5,
        'placeholder' => 'variété, conditionnement, aspect, saveur ...'
    ],])
            ->add('category')
            ->add('stores', EntityType::class, [
                'class' => Store::class,
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('s')
                    ->andWhere('s.owner = :val')
                    ->setParameter('val', $options['user']);
                },
                'choice_label' => 'name',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'user' => null,
        ]);
    }
}
