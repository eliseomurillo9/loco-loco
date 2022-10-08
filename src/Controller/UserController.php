<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
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

    #[Route('/favorite', name: 'favorite')]
    public function favorite(): Response
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

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
    }
}
