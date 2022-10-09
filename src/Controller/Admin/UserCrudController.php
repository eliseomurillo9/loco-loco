<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AddressType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
            TextField::new('lastname'),
            TextField::new('firstname'),
            TextField::new('email')->hideOnIndex(),
            TextField::new('plainPassword')->hideOnIndex(),
            ImageField::new('avatar')
                ->setBasePath('images/uploads/avatars')
                ->setUploadDir('public/images/uploads/avatars')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->hideOnIndex(),
            ArrayField::new('roles'),
            BooleanField::new('is_enabled'),
            CollectionField::new('Addresses')->setEntryType(AddressType::class)->hideOnIndex(),
            AssociationField::new('favourites')->hideOnIndex(),
        ];
    }
}
