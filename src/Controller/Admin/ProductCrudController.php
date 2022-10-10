<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\CategoryType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


   public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('name'),
            BooleanField::new('is_available'),
            MoneyField::new('price')->setCurrency('EUR')->hideOnIndex(),
            ImageField::new('picture')
            ->setBasePath('images/uploads/products')
            ->setUploadDir('public/images/uploads/products')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->hideOnIndex(),
            TextField::new('description')->hideOnIndex()->renderAsHtml(),
            AssociationField::new('category')->hideOnIndex()
        ];
    }


}
