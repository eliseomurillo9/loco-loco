<?php

namespace App\Controller\Admin;

use App\Entity\Store;
use App\Form\AddressType;
use App\Form\ProductType;
use App\Form\StoreHoursType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
            TextField::new('phone_number'),
            EmailField::new('email'),
            TextField::new('website'),
            TextField::new('siret_number'),
            TextField::new('picture'),
            TextEditorField::new('description'),
            TextEditorField::new('road_specificity'),
            CollectionField::new('addresses')->setEntryType(AddressType::class),
            CollectionField::new('storeHours')->setEntryType(StoreHoursType::class),
            CollectionField::new('products')->setEntryType(ProductType::class)
        ];
    }
}
