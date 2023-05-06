<?php

namespace App\Controller\Admin;

use App\Entity\Opinion;
use App\Enum\OpinionProductRateEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class OpinionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Opinion::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Product\'s opinion')
            ->setEntityLabelInPlural('Opinions');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('by_user', 'User'))
            ->add(EntityFilter::new('product'))
            ->add(ChoiceFilter::new('product_rate', 'Rate')->setChoices([
                'Awful' => OpinionProductRateEnum::Awful->value,
                'Bad' => OpinionProductRateEnum::Bad->value,
                'Can Be' => OpinionProductRateEnum::CanBe->value,
                'Good' => OpinionProductRateEnum::Good->value,
                'Amazing' => OpinionProductRateEnum::Amazing->value,
            ]))
            ->add(BooleanFilter::new('is_approved', 'Approved'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnDetail();
        yield AssociationField::new('by_user', 'User');
        yield AssociationField::new('product');
        yield ChoiceField::new('product_rate', 'Rate')
            ->setChoices(OpinionProductRateEnum::cases());
        yield TextareaField::new('product_comment', 'Comment');
        yield BooleanField::new('is_approved', 'Approved');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Action::INDEX, Action::NEW)
            ->remove(Action::INDEX, Action::EDIT)
            ->remove(Action::DETAIL, Action::EDIT);
    }
}
