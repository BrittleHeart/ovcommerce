<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use App\Service\MergedImageService;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class ProductDeleteSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private MergedImageService $imageService,
    ) {
    }

    public function onProductDeleteEvent(BeforeEntityDeletedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        if (!$entity instanceof Product) {
            return;
        }

        $background_url = "{$this->imageService->getUploadDir()}/{$entity->getBackgroundUrl()}";
        $cover_url = "{$this->imageService->getUploadDir()}/{$entity->getCoverUrl()}";

        $merged_url = $entity->getMergedUrl() ?? '';
        $merged_dir = $this->imageService->getMergedDirFromValue($merged_url);

        $this->imageService->deleteImages([
            $background_url,
            $cover_url,
            $merged_dir,
        ]);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityDeletedEvent::class => 'onProductDeleteEvent',
        ];
    }
}
