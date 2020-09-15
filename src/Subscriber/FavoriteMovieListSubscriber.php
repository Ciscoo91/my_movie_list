<?php

namespace App\Subscriber;

use App\Entity\User;
use Doctrine\ORM\Events;
use App\Entity\MovieList;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class FavoriteMovieListSubscriber implements EventSubscriber
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $user = $args->getObject();
        $em = $args->getObjectManager();
        dump($em, $user);
        // $favoriteList = new MovieList();
        // $favoriteList->setName("Favorite List");
        // $favoriteList->setDescription("List here the movies you like the most");
        // $favoriteList->setUser($user);
        // $this->em->persist($favoriteList);
        // $this->em->flush();
    }
    


}