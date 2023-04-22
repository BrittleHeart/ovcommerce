<?php

namespace App\Service;

use App\Dto\AbstractImageDto;
use Imagine\Image\ImageInterface;

abstract class ImageService
{
    protected const IMAGE_UPLOAD_DIR = 'uploads';

    public function __construct(
        /**
         * @see /var/www/config/services.yaml parameters:
         */
        protected string $uploadDir,
    ) {
    }

    abstract protected function setUploadDir(string $uploadDir): self;

    abstract public function getUploadDir(): string;

    abstract public function createThumbnail(?AbstractImageDto $dto): ?ImageInterface;

    abstract public static function getFilename(): string;

    abstract public function deleteImage(string $filename): void;
}
