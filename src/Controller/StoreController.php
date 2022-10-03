<?php

namespace App\Controller;

use App\entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/store', name: 'store_')]
class StoreController extends AbstractController
{
    public function __construct(private StoreRepository $storeRepository)
    {

    }
    #[Route('', name: '_index')]
    public function storeIndex(): Response
    {
        return $this->render('store/index.html.twig');
    }

    #[Route('/locator', name: '_locator')]
    public function storeLocator(): Response
    {
        return $this->render('store/farms-locator.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }
}
