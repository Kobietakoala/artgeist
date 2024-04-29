<?php declare(strict_types=1);

namespace Service\ReaderStrategy;

require_once 'config/global_const.php';

use App\Exception\FileDoesntExistException;
use App\Model\File;
use App\service\ReaderStrategy\SmallFileReader;
use PHPUnit\Framework\TestCase;

class SmallFileReaderTest extends TestCase
{
    private File $fileMock;
    private string $tmpFilePath;
    private string $sampleContent = 'test';

    public function setUp(): void
    {
        $this->fileMock = $this->createMock(File::class);
        $this->tmpFilePath = tempnam(FILES_PATH, "T");

        $this->fillFileWithContent();
        register_shutdown_function(function() {
            if(file_exists($this->tmpFilePath)) {
                unlink($this->tmpFilePath);
            }
        });
    }

    private function fillFileWithContent(): void
    {
        $handle = fopen($this->tmpFilePath, 'w');
        fwrite($handle, $this->sampleContent);
        fclose($handle);
    }

    public function testCannotCreateReaderWithoutFile(): void
    {
        $this->fileMock
            ->method('getPath')
            ->willReturn('');

        $this->expectException(FileDoesntExistException::class);

        new SmallFileReader($this->fileMock);
    }

    public function testCanCreateReaderWithFile(): SmallFileReader
    {
        $this->fileMock
            ->method('getPath')
            ->willReturn($this->tmpFilePath);

        $reader = new SmallFileReader($this->fileMock);

        $this->assertInstanceOf(SmallFileReader::class, $reader);

        return $reader;
    }

    /**
     * @depends testCanCreateReaderWithFile
     */
    public function testHasNextLineReturnTrueWhenNextLineExist(SmallFileReader $reader)
    {
        $this->assertTrue($reader->hasNexLine());

        return $reader;
    }

    /**
     * @depends testHasNextLineReturnTrueWhenNextLineExist
     */
    public function testCanReadLine(SmallFileReader $reader): SmallFileReader
    {
        $this->assertSame($this->sampleContent, $reader->readLine());

        return $reader;
    }

    /**
     * @depends testCanReadLine
     */
    public function testHasNextLineReturnFalseWhenNextLineDoesntExist(SmallFileReader $reader): void
    {
        $this->assertFalse($reader->hasNexLine());
    }
}