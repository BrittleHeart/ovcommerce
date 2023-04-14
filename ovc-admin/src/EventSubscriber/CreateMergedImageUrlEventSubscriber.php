<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\ImageService;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class CreateMergedImageUrlEventSubscriber implements EventSubscriberInterface
{
    private string $baseURL;
    private string $productUploadDir;

    public function __construct(
        private ImageService $imageService,
        private ProductRepository $productRepository,
        #[Autowire('%app.baseURL%')] string $baseURL,
        #[Autowire('%app.productUploadDir%')] string $productUploadDir,
    ) {
        $this->baseURL = $baseURL;
        $this->productUploadDir = $productUploadDir;
    }

    /**
     * @throws \Exception
     */
    public function createMergedImageUrl(AfterEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Product)) {
            return;
        }

        $background_url = $entity->getBackgroundUrl();
        $image_url = $entity->getCoverUrl();

        if (null === $image_url || null === $background_url) {
            return;
        }

        $this->imageService->setFront($image_url);
        $this->imageService->setBackground($background_url);

        $fileUniqueName = uniqid('merged_', true).'.jpg';
        $uploadPath = $this->productUploadDir.'/'.$fileUniqueName;
        $this->imageService->setFilename($uploadPath);

        $mergedImage = $this->imageService->createThumbnail();
        if (null !== $mergedImage && isset($mergedImage->metadata()['filepath'])) {
            $entity->setMergedUrl(
                "{$this->baseURL}/uploads/products/{$fileUniqueName}"
            );
        } else {
            throw new \Exception('File not found');
        }

        $this->productRepository->save($entity, true);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityPersistedEvent::class => 'createMergedImageUrl',
        ];
    }
}
