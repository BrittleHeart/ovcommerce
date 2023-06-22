<?php

namespace App\Dto;

abstract class AbstractImageDto extends Dto
{
    public function __construct(
        public string $uploadDir,
        public string $baseURL,
    ) {
    }
}
