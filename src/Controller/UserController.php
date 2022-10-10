<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Store;
use App\Entity\Product;
use App\Form\EditProfileType;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use App\Repository\StoreRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('', name: 'user_')]
class UserController extends AbstractController
{
    public function __construct(private UserRepository $userRepository)
    {

    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if user is already connected :
        /*    if ($this->getUser()) {
            return $this->redirectToRoute('main_index');
        }*/
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error,
        ]);
    }

    //Get and set User favourites stores
    #[Route('/favorite', name: 'favorite')]
    #[IsGranted('ROLE_USER')]
    public function favorite(): Response
    {
        $getFavorites = $this->getUser()->getFavourites()->getValues();

        return $this->render('user/favorite.html.twig', [
    "favoritesList" => $getFavorites]);

    }

    #[Route('/grocery-list', name: 'grocery-list')]
    #[IsGranted('ROLE_USER')]
    public function groceryList(): Response
    {

        $GroceriesList = $this->getUser()->getProducts()->getValues();


        return $this->render('user/grocery-list.html.twig', [
            'groceryList' => $GroceriesList
        ]);
    }

    #[Route('/remove-product/{id}', name: 'remove-product')]
    #[IsGranted('ROLE_USER')]
    public function removeProduct(Request $request, EntityManagerInterface $em, ProductRepository $productRepository, Product $product): Response
    {

        $productId = $product->getId();
        $user = $this->getUser();
        $user->removeProduct(
            $productRepository->find($productId)
        );

        $em->flush();   

        return $this->redirect($request->headers->get('referer'));

    }

    #[Route('/profil-client', name: 'profil-client')]
    public function profilClient(): Response
    {
        $userInfo = $this->getUser();

        return $this->render('user/profil-client.html.twig', [
            'user' => $userInfo,
        ]);
    }

    #[Route('/profile-edit', name: 'profile-edit')]
    #[IsGranted('ROLE_USER')]
    public function editProfile(
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $userInfo = $this->getUser();


        $form = $this->createForm(EditProfileType::class, $userInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $em->persist($userInfo);
            $em->flush();

            if ($this->isGranted('ROLE_PRODUCER')) {
            return $this->redirectToRoute('user_profil-pro');
            }
            else {

                return $this->redirectToRoute('user_profil-client');
            }
        }

    return $this->render('user/profil-client-edit.html.twig', [
        'user' => $userInfo,
        'formEdit' => $form->createView(),
    ]);
}


    #[Route('/remove/favorite/{id}', name: 'remove_favorite')]
    #[IsGranted('ROLE_USER')]
    public function removeFavorite(Request $request, StoreRepository $storeRepository, EntityManagerInterface $em, Store $store): Response
    {
        $storeId = $store->getId();
        $user = $this->getUser();
        $user->RemoveFavourite(
            $storeRepository->find($storeId)
        );
        $em->flush();   

        return $this->redirect($request->headers->get('referer'));

    }

    #[Route('/profil-pro', name: 'profil-pro')]
    #[IsGranted('ROLE_PRODUCER')]
    public function profilPro(): Response
    {
        $user = $this->getUser();
        return $this->render('user/profil-pro.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
    }

    #[Route(path: '/add/favorite/{id}', name: 'add_favorite')]
    #[IsGranted('ROLE_USER')]
    public function postFavorites(Request $request, StoreRepository $storeRepository, EntityManagerInterface $em, Store $store)
    {
            $storeId = $store->getId();
            $user = $this->getUser();
            $user->addFavourite(
                $storeRepository->find($storeId)
            );
            $em->flush();

        $this->addFlash('success', 'Le magasin a été ajouté à vos favoris');
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/add/shop-list/{id}', name: 'add_shop-list')]
    #[IsGranted('ROLE_USER')]
    //Add product to list
    public function form(Request $request, EntityManagerInterface $em, ProductRepository $productRepository, Product $product): Response
    {
        $productId = $product->getId();
        $user = $this->getUser();
        $user->addProduct(
            $productRepository->find($productId)
        );

        $em->flush();   

        return $this->redirect($request->headers->get('referer'));
        
    }

}
