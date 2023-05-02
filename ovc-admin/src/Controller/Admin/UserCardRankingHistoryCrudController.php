<?php

namespace App\Controller\Admin;

use App\Entity\UserCardRankingHistory;
use App\Enum\UserCardRankingHistoryActionEnum;
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

class UserCardRankingHistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserCardRankingHistory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Card Ranking History')
            ->setEntityLabelInPlural('Card Ranking Histories');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('loyality_card', 'Card'))
            ->add(EntityFilter::new('for_user', 'User'))
            ->add(ChoiceFilter::new('action')->setChoices([
                'New Card' => UserCardRankingHistoryActionEnum::NewCard->value,
                'Ranking Changed' => UserCardRankingHistoryActionEnum::CardRankingChanged->value,
                'Ranking Renewed' => UserCardRankingHistoryActionEnum::CardRankingRenewed->value,
                'Ranking Expired' => UserCardRankingHistoryActionEnum::CardRankingExpired->value,
                'User Assigned' => UserCardRankingHistoryActionEnum::UserAssigned->value,
                'Deactivated Card' => UserCardRankingHistoryActionEnum::DeactivatedCard->value,
            ]));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('for_user', 'User');
        yield AssociationField::new('loyality_card', 'Card');
        yield ChoiceField::new('action')
            ->setChoices(UserCardRankingHistoryActionEnum::cases());
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
