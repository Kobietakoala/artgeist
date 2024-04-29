<?php declare(strict_types=1);

namespace Service\Factory;

use App\Model\File;
use App\Service\Factory\FileReadStrategyFactory;
use App\Service\Factory\FileReadStrategyFactoryInterface;
use App\Service\ReaderStrategy\LargeFileReader;
use App\Service\ReaderStrategy\SmallFileReader;
use PHPUnit\Framework\TestCase;

class FileReadStrategyFactoryTest extends TestCase
{
    private FileReadStrategyFactoryInterface $factory;

    private File $fileMock;

    private string $tmpFilePath;

    public function setUp(): void
    {
        $this->fileMock = $this->createMock(File::class);
        $this->factory = new FileReadStrategyFactory();

        $this->tmpFilePath = tempnam(FILES_PATH, "T");

        register_shutdown_function(function() {
            if(file_exists($this->tmpFilePath)) {
                unlink($this->tmpFilePath);
            }
        });
    }

    public function testFactoryReturnSmallFileReaderOnSmallFile(): void
    {
        $this->fileMock
            ->expects(self::once())
            ->method('getPath')
            ->willReturn($this->tmpFilePath);

        $this->fileMock
            ->expects(self::once())
            ->method('getSize')
            ->willReturn(1);

        $reader = $this->factory->getFileReaderByFile($this->fileMock);

        $this->assertInstanceOf(SmallFileReader::class, $reader);
    }


    public function testFactoryReturnLargeFileReaderOnLargeFile(): void
    {
        $this->fileMock
            ->expects(self::once())
            ->method('getPath')
            ->willReturn($this->tmpFilePath);

        $this->fileMock
            ->expects(self::once())
            ->method('getSize')
            ->willReturn(MAX_SMALL_FILE_SIZE + 1);

        $reader = $this->factory->getFileReaderByFile($this->fileMock);

        $this->assertInstanceOf(LargeFileReader::class, $reader);
    }
}