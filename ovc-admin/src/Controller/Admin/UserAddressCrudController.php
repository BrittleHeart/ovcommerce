<?php

namespace App\Controller\Admin;

use App\Entity\UserAddress;
use App\Entity\UserAddressHistory;
use App\Repository\UserAddressHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class UserAddressCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UserAddressHistoryRepository $userAddressHistoryRepository,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return UserAddress::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['city', 'country', 'first_name', 'last_name'])
            ->setPageTitle(Action::INDEX, 'User Addresses');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('userPayments'))
            ->add(EntityFilter::new('userOrders'));
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_INDEX === $pageName || Crud::PAGE_DETAIL === $pageName) {
            yield IdField::new('id');
            yield AssociationField::new('for_user');
            yield TextField::new('address_1');
            yield TextField::new('address_2');
            yield TextField::new('postal_code');
            yield TextField::new('city');
            yield TextField::new('country');
            yield TextField::new('first_name');
            yield TextField::new('last_name');
            yield DateTimeField::new('created_at');
            yield AssociationField::new('userPayments')->onlyOnDetail();
            yield AssociationField::new('userOrders')->onlyOnDetail();
        }

        if (Crud::PAGE_EDIT === $pageName) {
            yield TextField::new('country');
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Action::INDEX, Action::NEW);
    }

    /**
     * @param UserAddress $entityInstance
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);

        if (!$entityInstance instanceof UserAddress) {
            return;
        }

        $userAddressHistory = new UserAddressHistory();
        $userAddressHistory->setForUser($entityInstance->getForUser());
        $userAddressHistory->setNewCountry($entityInstance->getCountry() ?? 'Poland');
        $this->userAddressHistoryRepository->save($userAddressHistory, true);
    }
}
