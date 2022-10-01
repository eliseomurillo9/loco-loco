<?php

namespace App\Controller\Admin;

use App\Entity\StoreHours;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class StoreHoursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StoreHours::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
        IntegerField::new('day'),
        TimeField::new('morning_opening_time'),
        TimeField::new('morning_closing_time'),
        TimeField::new('afternoon_opening_time'),
        TimeField::new('afternoon_closing_time'),
        AssociationField::new('store')
        ];
    }

}
