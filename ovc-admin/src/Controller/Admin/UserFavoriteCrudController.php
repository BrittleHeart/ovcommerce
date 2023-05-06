<?php

namespace App\Controller\Admin;

use App\Entity\UserFavorite;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class UserFavoriteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserFavorite::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Favorite')
            ->setEntityLabelInPlural('User Favorites');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('by_user', 'User'))
            ->add(EntityFilter::new('product'))
            ->add(DateTimeFilter::new('liked_at', 'Liked at'))
            ->add(DateTimeFilter::new('disliked_at', 'Disliked at'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('by_user', 'User');
        yield AssociationField::new('product');
        yield DateTimeField::new('liked_at', 'Liked At');
        yield DateTimeField::new('disliked_at', 'Disliked At');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Action::INDEX, Action::NEW)
            ->remove(Action::INDEX, Action::EDIT);
    }
}
