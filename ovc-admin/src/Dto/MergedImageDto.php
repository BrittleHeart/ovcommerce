<?php

namespace App\Dto;

class MergedImageDto extends AbstractImageDto
{
    public function __construct(
        public string $backgroundUrl,
        public string $coverUrl,
        public string $mergedDir,
        public string $baseURL,
        public string $uploadDir,
    ) {
        parent::__construct($this->uploadDir, $this->baseURL);
    }
}
