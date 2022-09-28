<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig');
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('user/login.html.twig');
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
        return $this->render('user/profil-client.html.twig');
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
}
