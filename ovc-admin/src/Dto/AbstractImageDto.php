<?php

namespace App\Dto;

abstract class AbstractImageDto
{
    public function __construct(
        public string $uploadDir,
        public string $baseURL,
    ) {
    }
}
