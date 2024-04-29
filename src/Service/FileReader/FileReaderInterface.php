<?php declare(strict_types=1);

namespace App\Service\FileReader;

use App\Model\File;

interface FileReaderInterface
{
    public function read(File $file): string;
}