<?php

namespace App\Service;

use App\Dto\AbstractImageDto;
use App\Dto\MergedImageDto;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

class MergedImageService extends ImageService
{
    public static string $filename;
    public static string $mergedFilenamePrefix = 'merged_';
    public static string $mergedFileExtension = '.jpg';
    private readonly Imagine $imagine;

    public function __construct(
        protected string $uploadDir,
        protected string $baseURL,
    ) {
        parent::__construct($this->uploadDir);

        self::$filename = uniqid(self::$mergedFilenamePrefix, true).self::$mergedFileExtension;
        $this->imagine = new Imagine();
    }

    public function getMergedDir(): string
    {
        return $this->getUploadDir().'/'.self::$filename;
    }

    public function getMergedUrl(): string
    {
        $imageUploadDir = self::IMAGE_UPLOAD_DIR;

        return "$this->baseURL/$imageUploadDir/products/".self::getFilename();
    }

    public function getMergedDirFromValue(string $filename): string
    {
        $merged_url = $filename;
        $merged_url = explode('/', $merged_url);
        $merged_url = end($merged_url);

        return "{$this->getUploadDir()}/{$merged_url}";
    }

    protected function setUploadDir(string $uploadDir): self
    {
        $this->uploadDir = $uploadDir;

        return $this;
    }

    public function getUploadDir(): string
    {
        return $this->uploadDir;
    }

    public static function getFilename(): string
    {
        return self::$filename;
    }

    /**
     * Creates a thumbnail for merged images: cover and background.
     * It uses an Imagine package, to copy, resize and merge.
     *
     * @throws \InvalidArgumentException - if $dto type is not MergedImageDto
     */
    public function createThumbnail(?AbstractImageDto $dto): ?ImageInterface
    {
        if (null === $dto) {
            return null;
        }

        if (!$dto instanceof MergedImageDto) {
            $dtoTypeOf = get_class($dto);
            throw new \InvalidArgumentException("Invalid DTO object. Given $dtoTypeOf, \App\Dto\MergedImageDto expected", 500);
        }

        if (!is_dir($this->getUploadDir())) {
            mkdir($this->getUploadDir());
        }

        $image = $this->imagine->open("{$this->getUploadDir()}/$dto->coverUrl");
        $bg = $this->imagine->open("{$this->getUploadDir()}/$dto->backgroundUrl");

        /* @phpstan-ignore-next-line */
        if (!($image instanceof ImageInterface) && !($bg instanceof ImageInterface)) {
            return null;
        }

        $image->resize(new Box(200, 200));
        $bg->resize(new Box(400, 400));
        $imageSize = $image->getSize();
        $backgroundSize = $bg->getSize();

        $imageWidth = ($backgroundSize->getWidth() - $imageSize->getWidth()) / 2;
        $imageHeight = ($backgroundSize->getHeight() - $imageSize->getHeight()) / 2;

        $image = $bg->paste($image, new Point((int) $imageWidth, (int) $imageHeight));

        return $image->save($this->getMergedDir());
    }

    public function deleteImage(string $filename): void
    {
        if (file_exists($filename) && !is_dir($filename)) {
            unlink($filename);
        }
    }

    /**
     * @param array<string> $files
     */
    public function deleteImages(array $files = []): void
    {
        if (empty($files)) {
            return;
        }

        foreach ($files as $file) {
            $this->deleteImage($file);
        }
    }
}
