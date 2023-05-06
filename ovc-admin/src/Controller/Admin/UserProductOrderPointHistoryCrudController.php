<?php

namespace App\Controller\Admin;

use App\Entity\UserProductOrderPointHistory;
use App\Enum\UserPaymentStatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;

class UserProductOrderPointHistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserProductOrderPointHistory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Order Point History')
            ->setEntityLabelInPlural('Order Points Histories');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('for_user', 'User'))
            ->add(EntityFilter::new('product'))
            ->add(EntityFilter::new('for_order', 'Order'))
            ->add(NumericFilter::new('points_earned', 'Points earned'))
            ->add(DateTimeFilter::new('created_at'));
    }

    /**
     * TODO: Add counting points subscriber for this history in persisting.
     */
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnDetail();
        yield AssociationField::new('for_user', 'User');
        yield AssociationField::new('product');
        yield AssociationField::new('for_order', 'Order');
        yield NumberField::new('points_earned', 'Points earned');
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
