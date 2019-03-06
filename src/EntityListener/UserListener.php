<?php
  
namespace App\EntityListener;
 
use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
 
class UserListener
{

    private $logger;
 
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
 
    public function postPersist(User $user, LifecycleEventArgs $event)
    {
        $this->logger->info('New User with id: ' . $user->getId() . ' has been created.');
    }

    public function postUpdate(User $user, LifecycleEventArgs $event)
    {
        $this->logger->info('User with id: ' . $user->getId() . ' has been updated.');
    }

    public function postRemove(User $user, LifecycleEventArgs $event)
    {
        $this->logger->info('User has been deleted.');
    }

}