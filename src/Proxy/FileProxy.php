<?php declare(strict_types=1);

namespace App\Proxy;

use App\Exception\CannotDownloadFileException;
use App\Model\File;
use App\Service\FileReader\FileReader;
use App\Service\FileReader\FileReaderInterface;

class FileProxy implements FileReaderInterface
{
    /**
     * @param FileReader $fileReader
     */
    public function __construct(private FileReader $fileReader) {}

    /**
     * @param File $file
     * @return string
     * @throws CannotDownloadFileException
     */
    public function read(File $file): string {
        if (!$file->isExist()) {
            $file = $this->downloadFile($file->getFileName());
        }

        return $this->fileReader->read($file);
    }

    /**
     * @param string $filename
     * @return File
     * @throws CannotDownloadFileException
     */
    private function downloadFile(string $filename): File {
        try {
            $fileContent = file_get_contents(REMOTE_URL . '/' . $filename);
        } catch (\Throwable $e) {
            throw new CannotDownloadFileException();
        }

        file_put_contents(FILES_PATH . '/' . $filename, $fileContent);
        return new File($filename);
    }
}