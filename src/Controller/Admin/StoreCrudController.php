<?php

namespace App\Controller\Admin;

use App\Entity\Store;
use App\Form\AddressType;
use App\Form\ProductType;
use App\Form\StoreHoursType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Store::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('phone_number')->hideOnIndex(),
            EmailField::new('email')->hideOnIndex(),
            TextField::new('website')->hideOnIndex(),
            TextField::new('siret_number')->hideOnIndex(),
            TextField::new('picture')->hideOnIndex(),
            TextEditorField::new('description')->hideOnIndex(),
            TextEditorField::new('road_specificity')->hideOnIndex(),
            CollectionField::new('addresses')->setEntryType(AddressType::class)->hideOnIndex(),
            CollectionField::new('storeHours')->setEntryType(StoreHoursType::class)->hideOnIndex(),
            CollectionField::new('products')->setEntryType(ProductType::class)->hideOnIndex(),
            AssociationField::new('owner')
        ];
    }
}
