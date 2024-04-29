<?php declare(strict_types=1);

namespace App\Service\ReaderStrategy;

use App\Exception\FileDoesntExistException;
use App\Model\File;

class SmallFileReader implements ReadStrategyInterface
{
    private $handle;

    public function __construct(File $file)
    {
        $this->open($file);
    }

    /**
     * @param File $file
     * @return void
     * @throws FileDoesntExistException
     */
    private function open(File $file): void
    {
        try{
            $this->handle = fopen($file->getPath(), 'r');
        } catch (\Throwable $e) {
            throw new FileDoesntExistException();
        }
    }

    /**
     * @return string|null
     */
    public function readLine(): ?string
    {
        return fgets($this->handle);
    }

    /**
     * @return void
     */
    private function close(): void
    {
        if ($this->handle) {
            fclose($this->handle);
        }
    }

    public function __destruct() {
        $this->close();
    }

    /**
     * @return bool
     */
    public function hasNexLine(): bool
    {
        return !feof($this->handle);
    }
}