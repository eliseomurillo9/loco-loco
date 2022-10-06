<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Store;
use App\Repository\ProductRepository;
use App\Repository\StoreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository, private PaginatorInterface $paginator)
    {

    }

    //Get all products of a store
    #[Route('', name: 'index')]
    public function getstoreProducts(StoreRepository $storeRepository): Response
    {
        /** @var Store $store */
        $store = $this->getproducts();
        return $this->render('product/test_product.html.twig',[
            'products' => $store,
        ]);
    }

}
