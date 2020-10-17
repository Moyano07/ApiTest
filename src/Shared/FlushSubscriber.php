<?php

namespace App\Shared;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FlushSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                ['onKernelView', 1000]
            ],
        ];
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onKernelView(ViewEvent $event)
    {
        $this->entityManager->flush();
    }
}
