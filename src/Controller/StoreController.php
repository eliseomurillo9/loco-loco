<?php

namespace App\Controller;

use App\entity\Store;
use App\Form\StoreType;
use App\Repository\AddressRepository;
use App\Repository\StoreRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Service\GeoUtilities;
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



    
    #[Route('/locator', name: 'locator')]
    public function storeLocator(
        Request $request, 
        GeoUtilities $geoUtilities,
        StoreRepository $storeRepository, 
        AddressRepository $addressRespostory): Response
    {

        $session = $request->getSession();
       $geoloc = $session->get('geolocation');
        

    
        // Récupération des infos dans la requete
        $searchbar = $request->get('searchbar');
        $categoryId = $searchbar['category'];
        $stores = $storeRepository->findByProductCategory($categoryId);

        // Récupération de la location de l'utilisateur
        $position = $geoUtilities->getUserLocationFromGoogleApi($searchbar['location']);

        // Calcul des distances pour chaque stores
        if ($position) {
            foreach ($stores as &$store) {
                $storeId = $store->getId();
                $storeLocation = $addressRespostory->find($storeId);
                dd($storeLocation);
                if($storeLocation) {
                    $distance = $geoUtilities->getDistanceFromLatLonInKm(
                        $position->lat, 
                        $position->lng,
                        $storeLocation->getLatitude(),
                        $storeLocation->getLongitude(),
                    );
                    $store->distance = $distance;
                }
            }
        }

      
                
        // TODO Trier le tableau par distance croissant

        return $this->render('store/farms-locator.html.twig', [
            'stores' => $stores
        ]);
    }
}
