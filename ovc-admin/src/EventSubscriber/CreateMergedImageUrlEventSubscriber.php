<?php

namespace App\EventSubscriber;

use App\Dto\MergedImageDto;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\MergedImageService;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class CreateMergedImageUrlEventSubscriber implements EventSubscriberInterface
{
    private string $baseURL;
    private string $productUploadDir;

    public function __construct(
        private ProductRepository $productRepository,
        private MergedImageService $imageService,
        #[Autowire('%app.baseURL%')] string $baseURL,
        #[Autowire('%app.productUploadDir%')] string $productUploadDir,
    ) {
        $this->baseURL = $baseURL;
        $this->productUploadDir = $productUploadDir;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function createMergedImageUrl(AfterEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Product)) {
            return;
        }

        $background_url = $entity->getBackgroundUrl();
        $cover_url = $entity->getCoverUrl();

        if (null === $cover_url || null === $background_url) {
            return;
        }

        $mergedImageDto = new MergedImageDto(
            $background_url,
            $cover_url,
            $this->imageService->getMergedDir(),
            $this->baseURL,
            $this->productUploadDir
        );

        $mergedImageDto->coverUrl = $cover_url;
        $mergedImageDto->backgroundUrl = $background_url;

        $mergedImageDto->uploadDir = $this->imageService->getUploadDir();

        $this->createImageThumbnail($mergedImageDto, $entity);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function createImageThumbnail(MergedImageDto $dto, Product $entity): void
    {
        $imageThumbnail = $this->imageService->createThumbnail($dto);
        if (null !== $imageThumbnail && isset($imageThumbnail->metadata()['filepath'])) {
            $entity->setMergedUrl($this->imageService->getMergedUrl());
        } else {
            throw new \InvalidArgumentException('Something is wrong with DTO.');
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
