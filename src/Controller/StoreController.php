<?php

namespace App\Controller;

use App\entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\Loader\Configurator\session;

#[Route('/store', name: 'store_')]
class StoreController extends AbstractController
{
    public function __construct(private StoreRepository $storeRepository)
    {
    }
    #[Route('', name: 'index')]
    public function storeIndex(): Response
    {
        return $this->render('store/index.html.twig');
    }

    #[Route('/location', name: 'location')]
    public function storeLocation(Request $request, )
    {
        $session = $request->getSession();

        $userPosition = $session->get('userPosition');

        
        return $userPosition;
    }


    #[Route('/locator', name: 'locator')]
    public function storeLocator(Request $request): Response
    {
        return $this->render('store/farms-locator.html.twig');
    }
}
