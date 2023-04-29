<?php

namespace App\Controller\Admin;

use App\Entity\LoyalityCard;
use App\Enum\LoyalityCardTypeEnum;
use App\Repository\LoyalityCardRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoyalityCardCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly LoyalityCardRepository $cardRepository,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return LoyalityCard::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnDetail();
        yield AssociationField::new('holder')->onlyOnDetail();
        yield TextField::new('card_number')->hideOnForm();
        yield ChoiceField::new('card_type')
            ->setChoices(LoyalityCardTypeEnum::cases());
        yield DateTimeField::new('issue_date');
        yield DateTimeField::new('expiration_date');
        yield BooleanField::new('is_active')
            ->renderAsSwitch(false);
        yield BooleanField::new('is_renewable')
            ->renderAsSwitch(false);
        yield NumberField::new('countPoints', 'Card Points')->hideOnForm();

        if (Crud::PAGE_DETAIL === $pageName) {
            yield DateTimeField::new('renewed_at');
            yield ArrayField::new('getLoyalityRewardsType', 'Rewards');
            yield NumberField::new('getRewardsCount', 'Rewards count');
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        $renewCard = Action::new('renew_card', 'Renew Card', 'fa fa-credit-card')
            ->linkToCrudAction('renewCardAction');

        return $actions
            ->add(Action::DETAIL, $renewCard);
    }

    /**
     * @throws \Exception
     */
    public function renewCardAction(AdminContext $context): ?RedirectResponse
    {
        $duration = new \DateInterval('P1Y');

        $loyaltyCard = $this->getEntity($context);
        if (null === $loyaltyCard) {
            return null;
        }

        if (false === $loyaltyCard->isIsRenewable()) {
            $this->addFlash('warning', 'Card is nonrenewable.');

            return $this->redirect($context->getReferrer() ?? '');
        }

        if (!$loyaltyCard->isExpired()) {
            $this->addFlash('warning', 'Don\'t renew a unexpired card');

            return $this->redirect($context->getReferrer() ?? '');
        }

        $this->cardRepository->renewCard($loyaltyCard, $duration);

        $this->addFlash('success', 'Card has been renewed.');

        return $this->redirect($context->getReferrer() ?? '');
    }

    public function getEntity(AdminContext $context): ?LoyalityCard
    {
        $entity = $context->getEntity()->getInstance();
        if (!is_object($entity)) {
            return null;
        }

        if (!$entity instanceof LoyalityCard) {
            return null;
        }

        return $entity;
    }
}
