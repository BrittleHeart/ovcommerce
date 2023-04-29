<?php

namespace App\Controller\Admin;

use App\Entity\LoyalityPoint;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class LoyalityPointCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LoyalityPoint::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('card');
        yield NumberField::new('points');

        if (Crud::PAGE_DETAIL === $pageName) {
            yield DateTimeField::new('created_at');
            yield DateTimeField::new('updated_at');
        }
    }
}
