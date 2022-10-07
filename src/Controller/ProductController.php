<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Store;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository, PaginatorInterface $paginator, StoreRepository $storeRepository)
    {

    }

    //Get all products of a store
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('product/test_product.html.twig');
    }

    //Add product
    #[Route('/add', name: 'create')]
    //Add new store by producer
    public function form(Request $request, SluggerInterface $slugger, StoreRepository $storeRepository): Response
    {
        $user = $this->getUser();
        $newProduct = new Product();

        $stores = $storeRepository->findBy(['owner' => $user], ['name' => 'ASC']);

        $form = $this->createForm(ProductType::class, $newProduct, ['stores'=>$stores]);
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
                        $this->getParameter('product_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }

                $newProduct->setPicture($newFilename);
            }
            //$newProduct->addStore($store);

           $newProduct->getStores($stores);//->getOwner()->getOwnedStores();//->addProduct($newProduct);

            $this->productRepository->add($newProduct,true);

            $this->addFlash('success', 'Votre boutique a été créée');
            return $this->redirectToRoute('main_index',[
                'id'=> $newProduct->getId()
            ]);
        }

        $this->addFlash('error', 'erreur lors de la création de votre boutique');
        return $this->render('product/test_product_form.html.twig',[
            'form' => $form->createView()
        ]);
    }



}
