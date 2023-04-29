<?php

namespace App\Controller\Admin;

use App\Entity\LoyalityReward;
use App\Enum\RewardTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;

class LoyalityRewardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LoyalityReward::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('loyality_card'))
            ->add(ChoiceFilter::new('reward_type')->setChoices([
                'Discount' => RewardTypeEnum::Discount->value,
                'Gift' => RewardTypeEnum::Gift->value,
                'Free Shipping' => RewardTypeEnum::FreeShipping->value,
            ]))
            ->add(NumericFilter::new('points_required'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield NumberField::new('points_required');
        yield ChoiceField::new('reward_type')
            ->setChoices(RewardTypeEnum::cases());
        yield NumberField::new('reward_value');
        yield AssociationField::new('loyality_card')
            ->setRequired(false);
    }
}
