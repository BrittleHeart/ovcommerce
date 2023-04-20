<?php

namespace App\Tests\Service;

use App\Dto\MergedImageDto;
use App\Service\MergedImageService;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MergedImageServiceTest extends KernelTestCase
{
    private MergedImageService $imageService;
    private string $baseURL;
    private string $uploadDir;

    private string $testUploadDir;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        self::bootKernel();
        /* @var MergedImageService $imageService */
        $this->imageService = self::getContainer()->get(MergedImageService::class);

        /* @var string $baseURL */
        $this->baseURL = self::getContainer()->getParameter('app.baseURL') ?? '';

        $this->uploadDir = self::getContainer()->getParameter('app.productUploadDir') ?? '';

        $this->testUploadDir = self::getContainer()->getParameter('test.productUploadDir') ?? '';
    }

    /**
     * @throws \Exception
     */
    #[Test]
    public function getMergedUrlShouldReturnAUrl(): void
    {
        $url = $this->imageService->getMergedUrl();

        $this->assertStringStartsWith("$this->baseURL/uploads/products", $url);
    }

    #[Test]
    public function getUploadDirShouldReturnServiceUploadDir(): void
    {
        $this->assertEquals($this->uploadDir, $this->imageService->getUploadDir());
    }

    #[Test]
    public function getFilenameReturnCorrectlyFormattedFilename(): void
    {
        $filename = $this->imageService::getFilename();
        $this->assertStringStartsWith(MergedImageService::$mergedFilenamePrefix, $filename);
    }

    #[Test]
    public function createThumbnailWithNullShouldReturnNull(): void
    {
        $thumbnail = $this->imageService->createThumbnail(null);
        $this->assertNull($thumbnail);
    }

    /**
     * @throws Exception
     */
    #[Test]
    public function createThumbnailWithMergedImageDtoCreatesThumbnail(): void
    {
        $mockImage = $this->createMock(ImageInterface::class);
        $mockImage->method('getSize')->willReturn(new Box(200, 200));

        $mockImagine = $this->createMock(ImagineInterface::class);
        $mockImagine->method('open')->willReturn($mockImage);

        $imageService = new TestMergedImageService($mockImagine, $this->testUploadDir, $this->baseURL);

        $dto = new MergedImageDto(
            'background.png',
            'avatar.png',
            $this->imageService->getMergedDir(),
            $this->baseURL,
            $this->testUploadDir
        );

        $image = $imageService->createThumbnail($dto);
        $this->assertInstanceOf(ImageInterface::class, $image);
    }

    #[Test]
    public function createThumbnailWithInvalidDtoThrowsException(): void
    {
        $wrongDto = new TestingDto($this->testUploadDir, $this->baseURL, false);
        $this->expectException(\InvalidArgumentException::class);
        $this->imageService->createThumbnail($wrongDto);
    }
}
