<?php

namespace App\Controller;

use App\entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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

    #[Route('/locator', name: 'locator')]
    public function storeLocator($searchBarInfo): Response
    {
        $userLocation = $searchBarInfo["location"];
        
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $userLocation . '&key=AIzaSyApzqVcCxJm5_ihnjWWQqrMJcGH4H1CKjo');

        $content = $response->getContent();
            
      
        dump($content);

        return $this->render('store/farms-locator.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }
}
