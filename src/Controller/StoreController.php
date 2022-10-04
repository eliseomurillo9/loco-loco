<?php

namespace App\Controller;

use App\entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function storeLocator(): Response
    {
        return $this->render('store/farms-locator.html.twig');
    }

    #[Route('/single', name: 'single')]
    public function storeSingle(): Response
    {
        return $this->render('store/single.html.twig');
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
    //Une method de controller doit obligatoirement retourner un type ("response")
    public function form(Request $request, SluggerInterface $slugger): Response
    {
        $newStore = new Store();
        $form = $this->createForm(StoreType::class, $newStore);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){


            $imageFile = $form->get('picture')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $newStore->setPicture($newFilename);
            }
            $this->storeRepository->add($newStore,true);
            $this->addFlash('success', 'Votre boutique a été créée');
            return $this->redirectToRoute('main_index',[
               // 'id'=> $newStore->getId()
            ]);
        }
        $this->addFlash('error', 'erreur lors de la création de votre boutique');
        return $this->render('store/test_store_form.html.twig',[
            'form' => $form->createView()
        ]);
    }
}