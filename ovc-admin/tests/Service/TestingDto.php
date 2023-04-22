<?php

namespace App\Tests\Service;

use App\Dto\AbstractImageDto;

class TestingDto extends AbstractImageDto
{
    public function __construct(
        public string $uploadDir,
        public string $baseURL,
        public bool $foo
    ) {
        parent::__construct($this->uploadDir, $this->baseURL);

        $this->foo = false;
    }
}
