<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use App\Repository\UserRepository;
use App\Repository\StoreRepository;
use Symfony\Component\Process\Process;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('', name: 'user_')]
class UserController extends AbstractController
{
    public function __construct(private UserRepository $userRepository)
    {

    }
    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig');
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

    #[Route('/favorite', name: 'favorite')]
    public function favorite(StoreRepository $storeRepository, EntityManagerInterface $em): Response
    {
      
       
        return $this->render('user/favorite.html.twig');
    }

    #[Route('/grocery-list', name: 'grocery-list')]
    public function groceryList(): Response
    {
        return $this->render('user/grocery-list.html.twig');
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

            return $this->redirectToRoute('user_profil-client');
        }

        return $this->render('user/profil-client-edit.html.twig', [
            'user' => $userInfo,
            'formEdit' => $form->createView(),
        ]);
    }

    #[Route('/profil-pro', name: 'profil-pro')]
    public function profilPro(): Response
    {
        return $this->render('user/profil-pro.html.twig');
    }

    #[Route('/add-place', name: 'add-place')]
    public function addPlace(): Response
    {
        return $this->render('user/add-place.html.twig');
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
    }

    #[Route(path: '/get/shop-id', name: 'get_shop_id', methods:["POST"])]
    public function getFavorites(Request $request, StoreRepository $storeRepository, EntityManagerInterface $em): Response
    {
        $session = new Session();
        $shopId = json_decode($request->getContent())->favoriteId;
        error_log($shopId);
        
        postFavorites($shopId);

        $session->set('shopId', $shopId);
        error_log($shopId);

       
        // dd($shopId);
        $response = new Response(
            $shopId,
            Response::HTTP_OK,
            ['content-type' => 'application/json'],
        );
       
        return $response;
    }

    #[Route(path: '/post/shop-id', name: 'post_shop_id')]
    public function postFavorites($storeId, StoreRepository $storeRepository, EntityManagerInterface $em)
{
    $session = new Session();

       $shopId = json_decode($session->get('shopId'))->favoriteId;

    $user = $this->getUser();

        $user = $this->getUser();
        $user->addFavourite(
            $storeRepository->find(3)
        );
        $em->flush();   
   
    return $shopId;
}
    


}
