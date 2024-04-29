<?php declare(strict_types=1);

namespace App\Service\Factory;

use App\Model\File;
use App\Service\ReaderStrategy\LargeFileReader;
use App\Service\ReaderStrategy\ReadStrategyInterface;
use App\Service\ReaderStrategy\SmallFileReader;

class FileReadStrategyFactory implements FileReadStrategyFactoryInterface
{
    /**
     * @param File $file
     * @return ReadStrategyInterface
     * @throws \App\Exception\FileDoesntExistException
     */
    public function getFileReaderByFile(File $file): ReadStrategyInterface
    {
        return $file->getSize() <= MAX_SMALL_FILE_SIZE ?
            new SmallFileReader($file) :
            new LargeFileReader($file);
    }
}