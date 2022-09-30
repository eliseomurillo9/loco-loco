<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StoreController extends AbstractController
{
    #[Route('/store', name: 'app_store')]
    public function index(): Response
    {
        return $this->render('store/index.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }

    #[Route('/store/locator', name: 'store_locator')]
    public function storeLocator(): Response
    {
        return $this->render('store/farms-locator.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }
}
