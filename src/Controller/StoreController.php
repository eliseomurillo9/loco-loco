<?php

namespace App\Controller;

use App\Entity\Store;
use App\Entity\StoreHours;
use App\Entity\User;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Knp\Component\Pager\PaginatorInterface;
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
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('store/index.html.twig', [
            'stores' => $user->getOwnedStores(),
        ]);
    }

/*    public function getStoreProduct(): Response
    {
        $product = $this->getProducts;
        return $this->render('product/test_product.html.twig',[
            'products' => $product,
        ]);
    }
 */

    #[Route('/locator', name: 'locator')]
    public function storeLocator(): Response
    {
        return $this->render('store/farms-locator.html.twig');
    }

    #[Route('/{id}', name: 'single', requirements:["id" => "\d+"])]
    public function storeSingle($id): Response
    {
        $singleStore = $this->storeRepository-> find($id);

        return $this->render('store/single.html.twig', ['singleStore' => $singleStore]);
    }

    #[Route('/single/about', name: 'single-about')]
    public function storeSingleAbout(): Response
    {
        return $this->render('store/single-about.html.twig');
    }

    #[Route('/edit', name: 'edit')]
    public function storeEdit(): Response
    {
        return $this->render('store/edit.html.twig');
    }

/*
    #[Route('/{name}', name: 'single', requirements:["id" => "\d+"])]
    public function storeSingle($id): Response
    {
        $singleStore = $this->storeRepository-> find($id);
        dump($singleStore);
        return $this->render('store/single.html.twig', ['singleStore' => $singleStore]);
    }
*/

    #[Route('/create', name: 'create')]
    //Add new store by producer
    public function form(Request $request, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $newStore = new Store();

        $form = $this->createForm(StoreType::class, $newStore);
      //  $newAddress = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
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

            $newStore->setOwner($user);
            $newStore->getAddresses()->first()->setStores($newStore);
            $this->storeRepository->add($newStore,true);

            $this->addFlash('success', 'Votre boutique a été créée');
            return $this->redirectToRoute('main_index',[
                'id'=> $newStore->getId()
            ]);
        }

        //$user = $this->manager->getRepository('App\Entity\User')->find('id');
        $this->addFlash('error', 'erreur lors de la création de votre boutique');
        return $this->render('store/test_store_form.html.twig',[
            'form' => $form->createView()
        ]);
    }
    #[Route('/addHours', name: 'hours')]
    //Add opening hours by store
    public function hoursform(Request $request): Response
    {
        $user = $this->getUser();
        $store = $this->getId();
        $addHours = new StoreHours();

        $form = $this->createForm(StoreType::class, $newStore);
        //  $newAddress = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $newStore->setOwner($user);
            $newStore->getAddresses()->first()->setStores($newStore);
            $this->storeRepository->add($newStore,true);

            $this->addFlash('success', 'Votre boutique a été créée');
            return $this->redirectToRoute('main_index',[
                'id'=> $newStore->getId()
            ]);
        }

        //$user = $this->manager->getRepository('App\Entity\User')->find('id');
        $this->addFlash('error', 'erreur lors de la création de votre boutique');
        return $this->render('store/test_store_form.html.twig',[
            'form' => $form->createView()
        ]);
    }
}