<?php declare(strict_types=1);

namespace Proxy;

use App\Decorator\UnixDecorator;
use App\Exception\CannotDownloadFileException;
use App\Model\File;
use App\Proxy\FileProxy;
use App\service\FileReader\FileReaderInterface;
use PHPUnit\Framework\TestCase;

class FileProxyTest extends TestCase
{
    private FileProxy $fileProxy;
    private File $fileMock;
    private FileReaderInterface $readerMock;

    public function setUp(): void
    {
        $this->fileMock = $this->createMock(File::class);
        $this->readerMock = $this->createMock(UnixDecorator::class);

        $this->fileProxy = new FileProxy($this->readerMock);
    }

    public function testReturnContentIfFileExist(): void
    {
        $content = 'test';

        $this->fileMock
            ->expects(self::once())
            ->method('isExist')
            ->willReturn(true);

        $this->readerMock
            ->expects(self::once())
            ->method('read')
            ->willReturn($content);

        $returnedContent = $this->fileProxy->read($this->fileMock);

        $this->assertSame($content, $returnedContent);
    }

    public function testDownloadFileThrowException(): void
    {
        $this->fileMock
            ->expects(self::once())
            ->method('isExist')
            ->willReturn(false);
        $this->fileMock
            ->expects(self::once())
            ->method('getFileName')
            ->willReturn('notExist.txt');

        $this->expectException(CannotDownloadFileException::class);

        $this->fileProxy->read($this->fileMock);
    }

    public function testCanDownloadFile(): void
    {
        $filePath = FILES_PATH . '/' . SAMPLE_FILE_NAME;
        $this->fileMock
            ->expects(self::once())
            ->method('isExist')
            ->willReturn(false);
        $this->fileMock
            ->expects(self::once())
            ->method('getFileName')
            ->willReturn(SAMPLE_FILE_NAME);

        $this->fileProxy->read($this->fileMock);

        $this->assertTrue(file_exists($filePath));
        unlink($filePath);
    }
}