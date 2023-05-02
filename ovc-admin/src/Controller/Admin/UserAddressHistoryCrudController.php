<?php

namespace App\Controller\Admin;

use App\Entity\UserAddressHistory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class UserAddressHistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserAddressHistory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User Addresses History')
            ->setEntityLabelInPlural('Users Addresses Histories')
            ->setSearchFields(['new_country']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('for_user'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield AssociationField::new('for_user');
        yield TextField::new('new_country');
        yield DateTimeField::new('created_at');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Action::INDEX, Action::NEW)
            ->remove(Action::INDEX, Action::DELETE)
            ->remove(Action::INDEX, Action::EDIT)
            ->remove(Action::DETAIL, Action::DELETE);
    }
}
