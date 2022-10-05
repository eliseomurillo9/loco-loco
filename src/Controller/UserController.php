<?php

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('', name: 'user_')]
class UserController extends AbstractController
{
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

        return $this->render('user/login.html.twig',[
            'lastUsername'=> $lastUsername,
            'error'=> $error,
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

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
    }

    #[Route('/location', name: 'location')]
    public function storeLocation(Request $request)
    {
        $session = $request->getSession();

        $searchBarInfo = $session->get('formData');
        $userLocation = $searchBarInfo["location"];

        if ($userLocation) {
            $client = HttpClient::create();
            $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $userLocation . '&key=AIzaSyApzqVcCxJm5_ihnjWWQqrMJcGH4H1CKjo');
    
            $content = json_decode($response->getContent(), true);
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
    
            $position = (object) array('lat' => $propertyAccessor->getValue($content, '[results][0][geometry][location][lat]'), 'lng' => $propertyAccessor->getValue($content, '[results][0][geometry][location][lng]'));
    
            $session->set('userPosition', $position);

            $response = new JsonResponse();
            $response->setContent(json_encode(
                ["position" => $position]
            ));
            $response->headers->set('Content-Type', 'application/json');
    
            return $response;
        }else{
            $geolocation = $request->get('geolocation');
            $session->set('geolocation', $geolocation);
        
            return $geolocation;
        }
    }


}
