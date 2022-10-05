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
        $session = $request->getSession();

        $searchForm = $this->createForm(SearchbarType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted()) {

            $session->set('formData', $searchForm->getData());

            return $this->redirectToRoute('store_locator');

        }



        return $this->render('main/index.html.twig', [
            'searchForm' => $searchForm->createView(),
        ]);
    }
}
