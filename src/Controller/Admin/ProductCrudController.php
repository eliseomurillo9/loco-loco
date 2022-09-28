<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\CategoryType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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
            NumberField::new('price'),
            TextField::new('picture'),
            TextEditorField::new('description'),
            AssociationField::new('category')
        ];
    }


}
