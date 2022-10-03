<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AddressType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;

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
            TextField::new('email'),
            TextField::new('plainPassword'),
            TextField::new('avatar'),
            ArrayField::new('roles'),
            BooleanField::new('is_enabled'),
            CollectionField::new('Addresses')->setEntryType(AddressType::class)
        ];
    }
}
