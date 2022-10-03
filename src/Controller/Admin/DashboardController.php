<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Store;
use App\Entity\StoreHours;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private readonly AdminUrlGenerator $adminUrlGenerator){

    }
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {


        $url = $this->adminUrlGenerator
            ->setController(ProductCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Loco Loco');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Product', 'fa-sharp fa-solid fa-basket-shopping', Product::class);
        yield MenuItem::linkToCrud('Store', 'fa-solid fa-shop', Store::class);
        yield MenuItem::linkToCrud('User', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Address', 'fa-solid fa-location-dot', Address::class);
        yield MenuItem::linkToCrud('StoreHours', 'fa-solid fa-clock', StoreHours::class);
        yield MenuItem::linkToCrud('Category', 'fa-solid fa-layer-group', Category::class);
    }
}
// Option 1. You can make your dashboard redirect to some common page of your backend
//
// $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
// return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

// Option 2. You can make your dashboard redirect to different pages depending on the user
//
// if ('jane' === $this->getUser()->getUsername()) {
//     return $this->redirect('...');
// }

// Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
// (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
//
// return $this->render('some/path/my-dashboard.html.twig');