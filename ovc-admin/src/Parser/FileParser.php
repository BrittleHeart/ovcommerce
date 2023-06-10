<?php

namespace App\Parser;

abstract class FileParser
{
    abstract public function parse(string $filePath): self;
}
