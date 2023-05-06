<?php

namespace App\Controller\Admin;

use App\Entity\LoyalityCard;
use App\Enum\LoyalityCardTypeEnum;
use App\Enum\UserCardRankingHistoryActionEnum;
use App\Repository\LoyalityCardRepository;
use App\Service\LoyaltyCardService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoyalityCardCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly LoyalityCardRepository $cardRepository,
        private readonly LoyaltyCardService $loyaltyCardService,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return LoyalityCard::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Loyalty Card')
            ->setEntityLabelInPlural('Loyalty Cards');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('holder', 'User'))
            ->add(ChoiceFilter::new('card_type', 'Card Type')->setChoices([
                'Silver' => LoyalityCardTypeEnum::Silver->value,
                'Gold' => LoyalityCardTypeEnum::Gold->value,
                'Platinum' => LoyalityCardTypeEnum::Platinum->value,
                'Diamond' => LoyalityCardTypeEnum::Diamond->value,
                'VIP' => LoyalityCardTypeEnum::VIP->value,
            ]))
            ->add(DateTimeFilter::new('issue_date'))
            ->add(DateTimeFilter::new('expiration_date'))
            ->add(BooleanFilter::new('is_active'))
            ->add(BooleanFilter::new('is_renewable'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnDetail();
        if (Crud::PAGE_EDIT === $pageName || Crud::PAGE_DETAIL === $pageName) {
            yield AssociationField::new('holder', 'User');
            yield ChoiceField::new('card_type')
                ->setChoices(LoyalityCardTypeEnum::cases());
            yield CollectionField::new('loyalityRewards', 'Rewards')
                ->allowAdd(false)
                ->renderExpanded(false)
                ->useEntryCrudForm();
        }
        yield TextField::new('card_number')->hideOnForm();
        yield DateTimeField::new('issue_date')->hideWhenUpdating();
        yield DateTimeField::new('expiration_date');
        yield BooleanField::new('is_active')
            ->renderAsSwitch(false);
        yield BooleanField::new('is_renewable')
            ->renderAsSwitch(false);
        yield NumberField::new('countPoints', 'Card Points')->hideOnForm();

        if (Crud::PAGE_DETAIL === $pageName) {
            yield DateTimeField::new('renewed_at');
            yield NumberField::new('getRewardsCount', 'Rewards count');
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        $renewCard = Action::new('renew_card', 'Renew Card', 'fa fa-credit-card')
            ->linkToCrudAction('renewCardAction');

        return $actions
            ->add(Action::DETAIL, $renewCard)
            ->remove(Action::INDEX, Action::DELETE)
            ->remove(Action::DETAIL, Action::DELETE);
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
        $this->loyaltyCardService->createCardHistoryWithAction($loyaltyCard, UserCardRankingHistoryActionEnum::CardRankingRenewed);

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
