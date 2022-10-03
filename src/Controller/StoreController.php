<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StoreController extends AbstractController
{
    #[Route('/store/locator', name: 'store_locator')]
    public function storeLocator(): Response
    {
        return $this->render('store/farms-locator.html.twig');
    }

    #[Route('/store/single', name: 'store_single')]
    public function storeSingle(): Response
    {
        return $this->render('store/single.html.twig');
    }

    #[Route('/store', name: 'store_index')]
    public function storeIndex(): Response
    {
        return $this->render('store/index.html.twig');
    }

    #[Route('/store/edit', name: 'store_edit')]
    public function storeEdit(): Response
    {
        return $this->render('store/edit.html.twig');
    }
}