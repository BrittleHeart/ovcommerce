<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\UserAccountStatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Users')
            ->setEntityLabelInSingular('User')
            ->setDefaultSort(['id' => 'ASC'])
            ->setSearchFields([
                'email',
                'username',
            ])
            ->setPaginatorPageSize(10);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('loyalityCard'))
            ->add(EntityFilter::new('userPayments'))
            ->add(EntityFilter::new('userAddresses'))
            ->add(ChoiceFilter::new('status')
            ->setChoices(UserAccountStatusEnum::cases()))
            ->add(BooleanFilter::new('is_email_verified'))
            ->add(DateTimeFilter::new('last_login'))
            ->add(DateTimeFilter::new('created_at'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('uuid')->onlyOnDetail();
        yield AssociationField::new('loyalityCard', 'Loyality Card')->onlyOnDetail();
        yield TextField::new('username')->hideOnForm();
        yield EmailField::new('email')->hideOnForm();
        yield ArrayField::new('roles');
        yield ChoiceField::new('status')
                ->setChoices(UserAccountStatusEnum::cases());
        yield BooleanField::new('is_email_verified', 'Email varified')
                ->renderAsSwitch(false)
                ->hideOnForm();
        yield DateTimeField::new('last_login')->hideOnForm();
        yield DateTimeField::new('created_at')->hideOnForm();
        yield DateTimeField::new('updated_at')->onlyOnDetail();
        yield AssociationField::new('userPayments')->onlyOnDetail();
        yield AssociationField::new('userAddresses')->onlyOnDetail();
        yield AssociationField::new('userAddressHistories')->onlyOnDetail();
        yield AssociationField::new('userOrders', 'Orders')->onlyOnDetail();
        yield AssociationField::new('userFavorites', 'Favorites')->onlyOnDetail();
        yield AssociationField::new('userProductOrderPointHistories')->onlyOnDetail();
        yield AssociationField::new('opinions')->onlyOnDetail();
        yield AssociationField::new('visitedUrls')->onlyOnDetail();
        yield AssociationField::new('userCardRankingHistories', 'Card ranking histories')->onlyOnDetail();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Action::INDEX, Action::NEW);
    }
}
