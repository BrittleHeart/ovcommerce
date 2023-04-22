<?php

namespace App\Controller\Admin;

use App\Entity\UserAccountStatusHistory;
use App\Enum\UserAccountActionEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class UserAccountStatusHistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserAccountStatusHistory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Action::INDEX, 'User Account Histories');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('operator'))
            ->add(EntityFilter::new('for_user'))
            ->add(ChoiceFilter::new('action')->setChoices([
                'Open' => UserAccountActionEnum::Open->value,
                'Blocked' => UserAccountActionEnum::Blocked->value,
                'Closed' => UserAccountActionEnum::Closed->value,
                'TemperamentallyClosed' => UserAccountActionEnum::TemporamentlyClosed->value,
            ]));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield AssociationField::new('operator');
        yield AssociationField::new('for_user');
        yield ChoiceField::new('action')
            ->setChoices(UserAccountActionEnum::cases());
        yield DateTimeField::new('created_at');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Action::INDEX, Action::NEW)
            ->remove(Action::INDEX, Action::DELETE)
            ->remove(Action::INDEX, Action::EDIT)
            ->remove(Action::DETAIL, Action::DELETE)
            ->remove(Action::DETAIL, Action::EDIT);
    }
}
