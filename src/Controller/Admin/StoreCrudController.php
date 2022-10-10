<?php

namespace App\Controller\Admin;

use App\Entity\Store;
use App\Form\AddressType;
use App\Form\EditProductType;
use App\Form\ProductType;
use App\Form\StoreHoursType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
            SlugField::new('slug')->setTargetFieldName('name'),
            TextField::new('phone_number')->hideOnIndex(),
            EmailField::new('email')->hideOnIndex(),
            TextField::new('website')->hideOnIndex(),
            TextField::new('siret_number')->hideOnIndex(),
            ImageField::new('picture')
                ->setBasePath('images/uploads/stores')
                ->setUploadDir('public/images/uploads/stores')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->hideOnIndex(),
            TextField::new('description')->hideOnIndex()->renderAsHtml(),
            TextField::new('road_specificity')->hideOnIndex()->renderAsHtml(),
            CollectionField::new('addresses')->setEntryType(AddressType::class)->hideOnIndex(),
            CollectionField::new('storeHours')->setEntryType(StoreHoursType::class)->hideOnIndex(),
            CollectionField::new('products')->setEntryType(ProductType::class)->hideOnIndex(),
            AssociationField::new('owner')
        ];
    }
}
