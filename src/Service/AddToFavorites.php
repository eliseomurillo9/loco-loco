<?php
namespace App\Service;

use App\Repository\UserRepository;
use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AddToFavorites
{

    public function addToFavorites($shop_id, StoreRepository $storeRepository, UserRepository $userRepository, EntityManagerInterface $em) {
        $userRepository = UserRepository::class;
        if ($shop_id) {
            $user = $userRepository->getUser();

            $user->addFavourite(
              $storeRepository->find($shop_id)  
            );
    
            $em->flush();        
    
        }
    }
}