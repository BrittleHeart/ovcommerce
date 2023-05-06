<?php

namespace App\Controller\Admin;

use App\Entity\UserPayment;
use App\Enum\UserPaymentStatusEnum;
use App\Enum\UserPaymentTypeEnum;
use App\Service\UserPaymentService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserPaymentCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UserPaymentService $paymentService,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return UserPayment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['for_user'])
            ->setEntityLabelInSingular('User Payment')
            ->setEntityLabelInPlural('User Payments');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('for_user'))
            ->add(EntityFilter::new('billing_address', 'Billing Address'))
            ->add(ChoiceFilter::new('status')->setChoices([
                'In Validation' => UserPaymentStatusEnum::InValidation->value,
                'Rejected' => UserPaymentStatusEnum::Rejected->value,
                'Accepted' => UserPaymentStatusEnum::Accepted->value,
            ]))
            ->add(ChoiceFilter::new('payment_type')->setChoices([
                'Cash' => UserPaymentTypeEnum::Cash->value,
                'Credit Card' => UserPaymentTypeEnum::CreditCard->value,
                'Debit Card' => UserPaymentTypeEnum::DebitCard->value,
                'Loyality Card' => UserPaymentTypeEnum::LoyalityCard->value,
                'Bank Transfer' => UserPaymentTypeEnum::BankTransfer->value,
                'PayPal' => UserPaymentTypeEnum::PayPal->value,
                'Other' => UserPaymentTypeEnum::Other->value,
            ]));
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('for_user');
        yield ChoiceField::new('payment_type')
            ->setChoices(UserPaymentTypeEnum::cases());
        yield TextField::new('card_number');
        yield TextField::new('cardholder_name');
        yield ChoiceField::new('status')
            ->setChoices(UserPaymentStatusEnum::cases());
        yield DateTimeField::new('card_expiration_day')->hideOnIndex();
        yield AssociationField::new('userOrders')->hideOnIndex();

        if (Crud::PAGE_DETAIL === $pageName) {
            yield IdField::new('id')->onlyOnDetail();
            yield CollectionField::new('billing_address');
            yield DateTimeField::new('created_at');
            yield DateTimeField::new('updated_at');
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        $acceptPayment = Action::new('acceptPayment', 'Accept', 'fa fa-check')
            ->linkToCrudAction('acceptPaymentAction');

        $rejectPayment = Action::new('rejectPayment', 'Reject', 'fa fa-times')
            ->linkToCrudAction('rejectPaymentAction');

        return $actions
            ->add(Action::DETAIL, $rejectPayment)
            ->add(Action::DETAIL, $acceptPayment)
            ->remove(Action::INDEX, Action::NEW)
            ->remove(Action::INDEX, Action::DELETE)
            ->remove(Action::INDEX, Action::EDIT)
            ->remove(Action::DETAIL, Action::DELETE)
            ->remove(Action::DETAIL, Action::EDIT);
    }

    public function acceptPaymentAction(AdminContext $context): ?RedirectResponse
    {
        $entity = $this->getEntity($context);
        if (null === $entity) {
            return null;
        }

        if (UserPaymentStatusEnum::Accepted->value === $entity->getStatus()) {
            $this->addFlash('warning', 'Payment method has already been accepted');

            return $this->redirect($context->getReferrer() ?? '');
        }

        $this->paymentService->acceptPayment($entity);
        $this->addFlash('success', 'Payment method has been accepted');

        return $this->redirect($context->getReferrer() ?? '');
    }

    public function rejectPaymentAction(AdminContext $context): ?RedirectResponse
    {
        $entity = $this->getEntity($context);
        if (null === $entity) {
            return null;
        }

        if (UserPaymentStatusEnum::Rejected->value === $entity->getStatus()) {
            $this->addFlash('warning', 'Payment method has already been rejected');

            return $this->redirect($context->getReferrer() ?? '');
        }

        $this->paymentService->rejectPayment($entity);
        $this->addFlash('success', 'Payment method has been rejected');

        return $this->redirect($context->getReferrer() ?? '');
    }

    private function getEntity(AdminContext $context): ?UserPayment
    {
        $entity = $context->getEntity()->getInstance();
        if (!is_object($entity)) {
            return null;
        }

        if (!$entity instanceof UserPayment) {
            $givenClass = get_class($entity);
            throw new \InvalidArgumentException("Invalid entity. App\Entity\UserPayment expected. $givenClass given");
        }

        return $entity;
    }
}
