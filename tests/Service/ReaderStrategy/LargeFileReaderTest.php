<?php declare(strict_types=1);

namespace Service\ReaderStrategy;

use App\Exception\FileDoesntExistException;
use App\Model\File;
use App\Service\ReaderStrategy\LargeFileReader;
use PHPUnit\Framework\TestCase;

class LargeFileReaderTest  extends TestCase
{
    private File $fileMock;
    private string $tmpFilePath;
    private string $sampleContent = 'test';

    public function setUp(): void
    {
        $this->fileMock = $this->createMock(File::class);
        $this->tmpFilePath = tempnam(FILES_PATH, "T");

        $this->fillFileWithSampleContent();
        register_shutdown_function(function() {
            if(file_exists($this->tmpFilePath)) {
                unlink($this->tmpFilePath);
            }
        });
    }

    private function fillFileWithSampleContent(): void
    {
        $handle = fopen($this->tmpFilePath, 'w');
        fseek($handle, MAX_READ_LARGE_FILE_LINE_BYTES,SEEK_END);
        fwrite($handle, $this->sampleContent);
        fclose($handle);
    }

    public function testCannotCreateReaderWithoutFile(): void
    {
        $this->fileMock
            ->method('getPath')
            ->willReturn('');

        $this->expectException(FileDoesntExistException::class);

        new LargeFileReader($this->fileMock);
    }

    public function testCanCreateReaderWithFile(): LargeFileReader
    {
        $this->fileMock
            ->method('getPath')
            ->willReturn($this->tmpFilePath);

        $reader = new LargeFileReader($this->fileMock);

        $this->assertInstanceOf(LargeFileReader::class, $reader);

        return $reader;
    }

    /**
     * @depends testCanCreateReaderWithFile
     */
    public function testHasNextLineReturnTrueWhenNextLineExist(LargeFileReader $reader)
    {
        $this->assertTrue($reader->hasNexLine());

        return $reader;
    }

    /**
     * @depends testHasNextLineReturnTrueWhenNextLineExist
     */
    public function testCanReadLineWithMaxLineBytes(LargeFileReader $reader): LargeFileReader
    {
        $this->assertSame(MAX_READ_LARGE_FILE_LINE_BYTES, strlen($reader->readLine()));
        $this->assertSame($this->sampleContent, $reader->readLine());

        return $reader;
    }

    /**
     * @depends testCanReadLineWithMaxLineBytes
     */
    public function testHasNextLineReturnFalseWhenNextLineDoesntExist(LargeFileReader $reader): void
    {
        $this->assertFalse($reader->hasNexLine());
    }
}
