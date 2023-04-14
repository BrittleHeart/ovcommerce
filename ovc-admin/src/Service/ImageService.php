<?php

namespace App\Service;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * TODO: Check if upload directory exists
 */
class ImageService
{
    private string $front = '';
    private string $background = '';
    private string $filename = '';
    private readonly string $productUploadDir;
    private readonly Imagine $imagine;

    public function __construct(
        #[Autowire('%app.productUploadDir%')] string $productUploadDir
    ) {
        $this->imagine = new Imagine();
        $this->productUploadDir = $productUploadDir;
    }

    public function setFront(string $front): self
    {
        $this->front = $front;

        return $this;
    }

    public function getFront(): string
    {
        return $this->front;
    }

    public function setBackground(string $background): self
    {
        $this->background = $background;

        return $this;
    }

    public function getBackground(): string
    {
        return $this->background;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function createThumbnail(): ?ImageInterface
    {
        $image = $this->imagine->open("{$this->productUploadDir}/{$this->getFront()}");
        $bg = $this->imagine->open("{$this->productUploadDir}/{$this->getBackground()}");

        /* @phpstan-ignore-next-line */
        if (!($image instanceof ImageInterface) && !($bg instanceof ImageInterface)) {
            return null;
        }

        $image->resize(new Box(200, 200));
        $imageSize = $image->getSize();
        $backgroundSize = $bg->getSize();

        $imageWidth = ($backgroundSize->getWidth() - $imageSize->getWidth()) / 2;
        $imageHeight = ($backgroundSize->getHeight() - $imageSize->getHeight()) / 2;

        $image = $bg->paste($image, new Point((int) $imageWidth, (int) $imageHeight));

        return $image->save($this->getFilename());
    }
}
