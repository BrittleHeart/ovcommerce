<?php

namespace App\Controller\Admin;

use App\Entity\UserPaymentHistory;
use App\Enum\UserPaymentStatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class UserPaymentHistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserPaymentHistory::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('for_user'))
            ->add(ChoiceFilter::new('payment_method_status')->setChoices([
                'Submitted' => UserPaymentStatusEnum::Submitted->value,
                'InValidation' => UserPaymentStatusEnum::InValidation->value,
                'Rejected' => UserPaymentStatusEnum::Rejected->value,
                'Accepted' => UserPaymentStatusEnum::Accepted->value
            ]));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield AssociationField::new('for_user');
        yield ChoiceField::new('payment_method_status')
            ->setChoices(UserPaymentStatusEnum::cases());
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
