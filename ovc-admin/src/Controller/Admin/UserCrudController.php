<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\UserAccountStatusHistory;
use App\Enum\UserAccountStatusEnum;
use App\Repository\UserAccountStatusHistoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserAccountStatusHistoryRepository $userAccountStatusHistoryRepository,
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
            ->setSearchFields([
                'email',
                'username',
            ]);
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
        return $actions
            ->remove(Action::INDEX, Action::NEW);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param User $entityInstance
     * @return void
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);
        if (!$entityInstance instanceof User) {
            return;
        }

        $operator = $this->getUser();
        if (!$operator instanceof User) {
            return;
        }

        $entityInstance->setUpdatedAt(new \DateTime());
        $this->userRepository->save($entityInstance);

        $userAccountStatusHistoryEntity = new UserAccountStatusHistory();

        $userAccountStatusHistoryEntity
            ->setOperator($operator)
            ->setForUser($entityInstance)
            ->setAction($entityInstance->getStatus() ?? UserAccountStatusEnum::Open->value)
            ->setCreatedAt(new \DateTimeImmutable());

        $this->userAccountStatusHistoryRepository->save($userAccountStatusHistoryEntity, true);
    }
}
