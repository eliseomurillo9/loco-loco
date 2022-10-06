<?php

namespace App\Controller;

use App\Data\SearchBar;
use App\Form\SearchbarType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('', name: 'main_')]
class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $searchForm = $this->createForm(SearchbarType::class);
        $searchForm->handleRequest($request);

        // $formData = $searchForm->getData();
        // if ($searchForm->isSubmitted()) {
        //     // dd($formData);
        //     $searchBarInfo = $this->forward('App\Controller\StoreController::storeLocator', [
        //         'searchBarInfo' => $formData,
        //     ]);
        //     return $searchBarInfo;
        //     // return $this->redirectToRoute('store_locator');
        // }
        return $this->render('main/index.html.twig', [
            'searchForm' => $searchForm->createView(),
        ]);
    }
}
