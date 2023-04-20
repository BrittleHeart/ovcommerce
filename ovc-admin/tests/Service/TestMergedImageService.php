<?php

namespace App\Tests\Service;

use App\Service\MergedImageService;
use Imagine\Image\ImagineInterface;

class TestMergedImageService extends MergedImageService
{
    public function __construct(
        public ImagineInterface $imagine,
        public string $uploadDir,
        public string $baseURL
    ) {
        parent::__construct($this->uploadDir, $this->baseURL);
    }
}