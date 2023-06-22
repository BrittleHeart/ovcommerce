<?php

namespace App\Parser;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class CsvFileParser extends FileParser
{
    public function parse(string $filePath, string $mode = 'r'): self
    {
        $stream = @fopen($filePath, $mode);
        if (false === $stream) {
            throw new FileNotFoundException("Could not find file from this location $filePath.");
        }

        while (false !== ($csvFile = fgetcsv($stream, 10000, ','))) {
            dump($csvFile);
        }

        fclose($stream);

        return $this;
    }
}
