<?php

namespace App\Controller\Admin;

use App\Entity\LoyalityCard;
use App\Enum\LoyalityCardTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LoyalityCardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LoyalityCard::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnDetail();
        yield TextField::new('card_number')->hideOnForm();
        yield ChoiceField::new('card_type')
            ->setChoices(LoyalityCardTypeEnum::cases());
        yield DateTimeField::new('issue_date');
        yield DateTimeField::new('expiration_date');
        yield BooleanField::new('is_active');
        yield BooleanField::new('is_renewable');

        if (Crud::PAGE_DETAIL === $pageName) {
            yield DateTimeField::new('renewed_at');
            yield AssociationField::new('holder');
            yield AssociationField::new('loyalityPoints');
            yield AssociationField::new('loyalityRewards');
        }
    }

    /**
     * TODO: Add action to be able to renew a loyalty card - Create a service
     */
}
