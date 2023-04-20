<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Coupon;
use App\Entity\LoyalityCard;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\UserAccountStatusHistory;
use App\Entity\UserAddress;
use App\Entity\UserAddressHistory;
use App\Entity\UserPayment;
use App\Entity\UserPaymentHistory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(UserCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('OVCommerce Admin Panel');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Back to website', 'fa fa-home', 'http://localhost');

        yield MenuItem::section('Main');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Go to API', 'fas fa-link', 'api');

        yield MenuItem::section('User');
        yield MenuItem::linkToCrud('User', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('User Address', 'fas fa-address-card', UserAddress::class);
        yield MenuItem::linkToCrud('User Payment', 'fas fa-credit-card', UserPayment::class);

        yield MenuItem::section('Products');
        yield MenuItem::linkToCrud('Product', 'fa fa-shopping-cart', Product::class);
        yield MenuItem::linkToCrud('Product Category', 'fa fa-tag', Category::class);
        yield MenuItem::linkToCrud('Product Coupon', 'fa fas fa-ticket-alt', Coupon::class);

        yield MenuItem::section('Loyalty system');
        yield MenuItem::linkToCrud('Loyality Card', 'fas fa-id-card', LoyalityCard::class);

        yield MenuItem::section('histories');
        yield MenuItem::linkToCrud('User History', 'fa fa-history', UserAccountStatusHistory::class);
        yield MenuItem::linkToCrud('User Address History', 'fa fa-history', UserAddressHistory::class);
        yield MenuItem::linkToCrud('User Payment Status History', 'fa fa-history', UserPaymentHistory::class);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Action::INDEX, Action::DETAIL);
    }

    public function configureCrud(): Crud
    {
        $crud = parent::configureCrud();

        return $crud
            ->setPaginatorPageSize(10)
            ->setDefaultSort(['id' => 'ASC']);
    }

}
