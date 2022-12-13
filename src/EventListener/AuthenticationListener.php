<?php

namespace App\EventListener;

use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;


class AuthenticationListener {
    public function beforeLogin(AuthenticationSuccessEvent $event){
        $user = $event->getAuthenticationToken()->getUser();
        if (!$user->isVerified()) {            
                throw new AuthenticationException("Merci de vérifier vos email et valider votre compte.");
        }
    }
}

