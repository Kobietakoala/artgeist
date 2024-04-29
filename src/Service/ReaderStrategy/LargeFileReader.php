<?php declare(strict_types=1);

namespace App\Service\ReaderStrategy;

use App\Exception\FileDoesntExistException;
use App\Model\File;

class LargeFileReader implements ReadStrategyInterface
{
    private $handle;

    /**
     * @param File $file
     * @throws FileDoesntExistException
     */
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
     * @return string
     */
    public function readLine(): string
    {
        return fread($this->handle, MAX_READ_LARGE_FILE_LINE_BYTES);
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