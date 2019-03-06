<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogSubscriber implements EventSubscriberInterface
{
    public function onApiCall($event)
    {
        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
           'api.call' => 'onApiCall',
        ];
    }
}
