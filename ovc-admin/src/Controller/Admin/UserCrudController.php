<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\UserAccountStatusHistory;
use App\Enum\UserAccountActionEnum;
use App\Enum\UserAccountStatusEnum;
use App\Enum\UserRolesEnum;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
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
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserService $userService,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Users')
            ->setEntityLabelInSingular('User')
            ->setDefaultSort(['status' => 'ASC'])
            ->setSearchFields([
                'email',
                'username',
            ]);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('loyality_card'))
            ->add(EntityFilter::new('userPayments'))
            ->add(EntityFilter::new('userAddresses'))
            ->add(ChoiceFilter::new('status')
            ->setChoices(UserAccountStatusEnum::cases())
                ->setChoices([
                    'Open' => UserAccountStatusEnum::Open->value,
                    'Blocked' => UserAccountStatusEnum::Blocked->value,
                    'Closed' => UserAccountStatusEnum::Closed->value,
                    'Email not Verified' => UserAccountStatusEnum::EmailNotVerified->value,
                    'Temporamently Closed' => UserAccountStatusEnum::TemporamentlyClosed->value,
                ])
            )
            ->add(BooleanFilter::new('is_email_verified'))
            ->add(DateTimeFilter::new('last_login'))
            ->add(DateTimeFilter::new('created_at'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('uuid')->onlyOnDetail();
        yield AssociationField::new('loyality_card')
            ->hideOnIndex()
            ->setRequired(false);
        yield TextField::new('username')->onlyOnDetail();
        yield EmailField::new('email')->onlyOnDetail();
        yield ArrayField::new('roles');
        yield ChoiceField::new('status')
                ->setChoices([
                    'Open' => UserAccountStatusEnum::Open->value,
                    'Closed' => UserAccountStatusEnum::Closed->value,
                    'Blocked' => UserAccountStatusEnum::Blocked->value,
                    'Temporamently Closed' => UserAccountStatusEnum::TemporamentlyClosed->value,
                    'Email Not Verified' => UserAccountStatusEnum::EmailNotVerified->value,
                ]);
        yield BooleanField::new('is_email_verified', 'Email varified')
                ->renderAsSwitch(false)
                ->hideOnForm();
        yield DateTimeField::new('last_login')->hideOnForm();
        yield DateTimeField::new('created_at')->hideOnForm();
        yield DateTimeField::new('updated_at')->hideOnForm();
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
        $banUserAction = Action::new('ban_user', 'Ban User', 'fa fa-ban')
            ->linkToCrudAction('banUserAction');

        $unblockUser = Action::new('unblock_user', 'Unblock User', 'fa fa-unlock-alt')
            ->linkToCrudAction('unblockUserAction');

        return $actions
            ->remove(Action::INDEX, Action::NEW)
            ->add(Action::DETAIL, $banUserAction)
            ->add(Action::DETAIL, $unblockUser);
    }

    public function banUserAction(AdminContext $context): ?RedirectResponse
    {
        $entity = $this->getEntity($context);
        if (null === $entity) {
            return null;
        }

        $operator = $this->getUser();
        if (!$operator instanceof User) {
            return null;
        }

        if (UserAccountStatusEnum::Blocked->value === $entity->getStatus()) {
            $this->addFlash('warning', "User {$entity->getusername()} is already blocked.");

            return $this->redirect($context->getReferrer() ?? '');
        }

        if (in_array(UserRolesEnum::Admin->value, $entity->getRoles())) {
            $this->addFlash('danger', 'Administrator group cannot be blocked.');

            return $this->redirect($context->getReferrer() ?? '');
        }

        $this->userRepository->changeUserStatus($entity, UserAccountStatusEnum::Blocked);

        $userHistory = new UserAccountStatusHistory();
        $this->userService->updateUserHistory(
            $userHistory,
            $operator,
            $entity,
            UserAccountActionEnum::from($entity->getStatus() ?? UserAccountActionEnum::Open->value)
        );

        $this->addFlash('success', "User {$entity->getusername()} has been blocked.");

        return $this->redirect($context->getReferrer() ?? '');
    }

    public function unblockUserAction(AdminContext $context): ?RedirectResponse
    {
        $entity = $this->getEntity($context);
        if (null === $entity) {
            return null;
        }

        $operator = $this->getUser();
        if (!$operator instanceof User) {
            return null;
        }

        if (UserAccountStatusEnum::Open->value === $entity->getStatus()) {
            $this->addFlash('warning', "User {$entity->getusername()} is already unblocked.");

            return $this->redirect($context->getReferrer() ?? '');
        }

        $this->userRepository->changeUserStatus($entity, UserAccountStatusEnum::Open);
        $userHistory = new UserAccountStatusHistory();
        $this->userService->updateUserHistory(
            $userHistory,
            $operator,
            $entity,
            UserAccountActionEnum::Open
        );

        $this->addFlash('success', "User {$entity->getusername()} has been unblocked.");

        return $this->redirect($context->getReferrer() ?? '');
    }

    /**
     * @param User $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);

        $operator = $this->getUser();
        $userHistory = new UserAccountStatusHistory();

        if (!$operator instanceof User) {
            return;
        }

        $this->userRepository->updateUserLastChangesTimestamp($entityInstance);

        $this->userService->updateUserHistory(
            $userHistory,
            $operator,
            $entityInstance,
            UserAccountActionEnum::from($entityInstance->getStatus() ?? UserAccountActionEnum::Open->value)
        );
    }

    public function getEntity(AdminContext $context): ?User
    {
        $entity = $context->getEntity()->getInstance();

        if (!is_object($entity)) {
            return null;
        }

        if (!$entity instanceof User) {
            $givenClass = get_class($entity);
            throw new \InvalidArgumentException("Invalid entity. App\Entity\User expected. $givenClass given");
        }

        return $entity;
    }
}
