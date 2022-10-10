<?php

namespace App\Controller;


use Error;

use App\Entity\Address;
use App\Service\GeoUtilities;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\session;

use App\Entity\Store;
use App\Entity\User;
use App\Form\StoreType;
use App\Repository\AddressRepository;
use App\Repository\StoreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;



#[Route('/store', name: 'store_')]
class StoreController extends AbstractController
{
    public function __construct(private StoreRepository $storeRepository, PaginatorInterface $paginator)
    {
    }

    #[Route('', name: 'index')]

    // show all producer stores
    public function storeIndex(): Response
    {
        $stores = $this->storeRepository->findBy([], ['name' => 'ASC']);

        return $this->render('store/index.html.twig', [
            'stores' => $stores,
        ]);
    }

    #[Route('/pro', name: 'indexpro')]
    #[IsGranted('ROLE_PRODUCER')]
    // show all producer stores
    public function storeIndexPro(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('store/indexpro.html.twig', [
            'stores' => $user->getOwnedStores(),
        ]);
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
            
            $userCity = $propertyAccessor->getValue($content, '[results][0][formatted_address]');
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
                    $storePositon = (object) ['lat' => $storeLocation->getLatitude(), 'lng' => $storeLocation->getLongitude()];
                   
                    array_push($storesList, $store);
                    array_push($storeAddressList, $storePositon);
                }
            }

            
            $session->set('storeCoords', $storeAddressList);
            $session->set('userCoords', $position);
        // TODO Trier le tableau par distance croissant
        return $this->render('store/farms-locator.html.twig', [
            'stores' => $storesList,
            'position' => $position,
            'addressList' => $storeAddressList,
            'range' => $range
        ]);
    }

    #[Route('/address_list', name: 'address_list',  methods: ['GET'])]
    public function storesList(Request $request)
    {
        $session = $request->getSession();

        $addresses = $session->get('storeCoords');
        $userCoords = $session->get('userCoords');

        $data = ['storeCoords' => $addresses, 'userCoords' => $userCoords];
       
        // error_log($addresses);
        // dd($addresses);

       $response = new JsonResponse($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
}


/*    #[Route('/products', name: 'store-products', requirements:["id" => "\d+"])]
   public function getStoreProduct($id): Response
    {
        $store = $this->storeRepository->find($id);
        $product = $this->$store->getProducts();
        return $this->render('product/product_list.html.twig',[
            'products' => $product,
        ]);
    }*/


    // Get single store information
    #[Route('/boutique/{slug}', name: 'single')]
    public function storeSingle(Store $store = null): Response
    {
        $storeAddress = $store->getAddresses()->getValues();
        return $this->render('store/single.html.twig',
         ['storeInfo' => $store,
         'storeAddress' => $storeAddress
        ]);
    }

    #[Route('/single/about/{slug}', name: 'single-about')]
    public function storeSingleAbout(Store $store = null): Response
    {
        $storeAddress = $store->getAddresses()->getValues();

        return $this->render('store/single-about.html.twig', [
            'storeInfo' => $store,
            'storeAddress' => $storeAddress

        ]);
    }


    #[Route('/create', name: 'create')]
    #[IsGranted('ROLE_PRODUCER')]
    //Add new store by producer
    public function form(Request $request, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $newStore = new Store();

        $form = $this->createForm(StoreType::class, $newStore);
       

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $address = $form->get('addresses')->getData();
            $client = HttpClient::create();
            $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address->getValues()[0]->getStreet() . '+' . $address->getValues()[0]->getCity() . '+' . $address->getValues()[0]->getZipcode() . '&key=AIzaSyApzqVcCxJm5_ihnjWWQqrMJcGH4H1CKjo');
    
            $content = json_decode($response->getContent(), true);

            $storeLat = $content['results'][0]['geometry']['location']['lat'];
            $storeLng = $content['results'][0]['geometry']['location']['lng'];

            $imageFile = $form->get('picture')->getData();
            // upload images
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }

                $newStore->setPicture($newFilename);
            }
            $name= $form->get('name')->getData();
            $newStore->setSlug($slugger->slug($name));
            $newStore->setOwner($user);
            $newStore->getAddresses()->first()->setStores($newStore);
            $newStore->getAddresses()->first()->setLatitude($storeLat);
            $newStore->getAddresses()->first()->setLongitude($storeLng);
            $this->storeRepository->add($newStore,true);

            $this->addFlash('success', 'Votre boutique a été créée');
            return $this->redirectToRoute('main_index',[
                'id'=> $newStore->getId()
            ]);
        }


        return $this->render('store/store_form.html.twig',[
            'form' => $form->createView()
        ]);
    }

}

