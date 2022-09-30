<?php 

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Form\RegistrationFormType;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct (private UserPasswordHasherInterface $hasher)
    {
    }

    public function beforeEntityPersistedEvent($event)
    {
        $user = $event->getEntityInstance();
        if (!($user instanceof User)){
            return;
        }
        $hashed = $this->hasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($hashed);
    }
 // Prévoir fonction pour modifications
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['beforeEntityPersistedEvent'],
            BeforeEntityUpdatedEvent::class => ['beforeEntityPersistedEvent'],
        ];
    }
}