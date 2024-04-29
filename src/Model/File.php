<?php declare(strict_types=1);

namespace App\Model;

class File
{
    private string $path;

    /**
     * @param string $filename
     */
    public function __construct(private string $filename) {
        $this->path = FILES_PATH . '/' . $this->filename;
    }

    /**
     * @return string
     */
    public function getFileName() {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return filesize($this->path);
    }

    /**
     * @return bool
     */
    public function isExist(): bool
    {
        return file_exists($this->path);
    }
}