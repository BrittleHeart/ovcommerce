<?php

namespace App\Controller\Admin;

use App\Entity\UserOrder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;

class UserOrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserOrder::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User Order')
            ->setEntityLabelInPlural('Users Orders');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('by_user', 'User'))
            ->add(EntityFilter::new('shipping_address', 'Address'))
            ->add(EntityFilter::new('payment_method', 'Payment'))
            ->add(DateTimeFilter::new('order_date'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('by_user');
        yield AssociationField::new('shipping_address', 'Shipping Address');
        yield AssociationField::new('payment_method', 'Payment Method');
        yield DateTimeField::new('order_date', 'Ordered at');
        yield NumberField::new('countTotalPrice')->onlyOnDetail();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Action::INDEX, Action::NEW)
            ->remove(Action::INDEX, Action::EDIT)
            ->remove(Action::DETAIL, Action::EDIT);
    }
}
