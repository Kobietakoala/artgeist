<?php declare(strict_types=1);

namespace App\Service\Factory;

use App\Model\File;
use App\Service\ReaderStrategy\ReadStrategyInterface;

interface FileReadStrategyFactoryInterface
{
    public function getFileReaderByFile(File $file): ReadStrategyInterface;
}