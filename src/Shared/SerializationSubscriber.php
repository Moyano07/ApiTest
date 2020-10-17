<?php

namespace App\Shared;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SerializationSubscriber implements EventSubscriberInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                ['onKernelView', 0]
            ],
        ];
    }

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelView(ViewEvent $event)
    {
        $value = $event->getControllerResult();

        if(is_null($value)) {
            $response = new JsonResponse('');
        } else {
            $response = new Response($this->serializer->serialize($value, "json", SerializationContext::create()->enableMaxDepthChecks()));
        }
        
        $event->setResponse($response);
    }
}
