<?php

namespace App\Controller;

use Error;
use App\entity\Store;
use App\Entity\Address;
use App\Form\StoreType;
use App\Service\GeoUtilities;
use App\Repository\StoreRepository;
use App\Repository\AddressRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
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
        

    
        // Récupération des infos dans la requete
        $searchbar = $request->get('searchbar');
        $categoryId = $searchbar['category'];
        $range = $searchbar['range'];
        
        // get real time position or address typed
        if ($searchbar['location']) {
            $address = $searchbar['location'];
            $client = HttpClient::create();
            $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=AIzaSyApzqVcCxJm5_ihnjWWQqrMJcGH4H1CKjo');
    
            $content = json_decode($response->getContent(), true);
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
    
            $position = (object) array('lat' => $propertyAccessor->getValue($content, '[results][0][geometry][location][lat]'), 'lng' => $propertyAccessor->getValue($content, '[results][0][geometry][location][lng]'));
            
        }else {
            $getPosition = $session->get('geolocation');
            $position = json_decode($getPosition->getContent())->geolocation;
        }
        $stores = $storeRepository->findByProductCategory($categoryId);
        
        // Récupération de la location de l'utilisateur
        $storesList = array();
        $storeAddressList = array();
        // Calcul des distances pour chaque stores
        foreach ($stores as &$store) {
            $storeLocation = $store->getAddresses($store->getId())->getValues()[0];
                
                if($storeLocation) {
                    $distance = $geoUtilities->getDistanceFromLatLonInKm(
                        $position->lat, 
                        $position->lng,
                        $storeLocation->getLatitude(),
                        $storeLocation->getLongitude(),
                    );
                   $store->distance = $distance;
                //    dd($distance);
                }
                
                if ($store->distance <= $range) {
                    array_push($storesList, $store);
                    array_push($storeAddressList, $storeLocation);
                }
            }
            $session->set('addressList', $storeAddressList);
                
        // TODO Trier le tableau par distance croissant
        return $this->render('store/farms-locator.html.twig', [
            'stores' => $storesList,
            'position' => $position,
            'addressList' => $storeAddressList
        ]);
    }

    #[Route('/address_list', name: 'address_list',  methods: ['GET'])]
    public function storesList(Request $request)
    {
        $session = $request->getSession();

        $addresses = $session->get('addressList');
        // dd($addresses);
        
        // dd($addressList);
        header('Content-Type: application/json');
        return new JsonResponse($addresses);

       
}
}
