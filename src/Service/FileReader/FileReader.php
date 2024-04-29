<?php

namespace App\Service\FileReader;

use App\Model\File;
use App\Service\Factory\FileReadStrategyFactory;
use App\Service\ReaderStrategy\ReadStrategyInterface;

abstract class FileReader implements FileReaderInterface
{
    private ?ReadStrategyInterface $reader = null;

    /**
     * @param FileReadStrategyFactory $factory
     */
    public function __construct(private FileReadStrategyFactory $factory) {}

    /**
     * @param File $file
     * @return string
     */
    public function read(File $file): string
    {
        $content = '';

        if($this->reader === null) {
            $this->reader = $this->factory->getFileReaderByFile($file);
        }

        while($this->reader->hasNexLine()) {
            $content .= $this->readLine();
        }

        return $content;
    }

    /**
     * @return string|null
     */
    protected function readLine(): ?string
    {
        return $this->reader->readLine();
    }
}