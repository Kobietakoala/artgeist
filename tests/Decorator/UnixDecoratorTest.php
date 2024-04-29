<?php declare(strict_types=1);

namespace Decorator;

use App\Decorator\UnixDecorator;
use App\Model\File;
use App\service\Factory\FileReadStrategyFactory;
use App\service\Factory\FileReadStrategyFactoryInterface;
use App\service\FileReader\FileReaderInterface;
use App\service\ReaderStrategy\LargeFileReader;
use App\service\ReaderStrategy\ReadStrategyInterface;
use App\service\ReaderStrategy\SmallFileReader;
use PHPUnit\Framework\TestCase;

class UnixDecoratorTest extends TestCase
{
    private FileReaderInterface $decorator;
    private File $fileMock;
    private ReadStrategyInterface $readerMock;
    private FileReadStrategyFactoryInterface $factoryMock;
    private string $sampleContent = 'test\\r\\r';

    public function setUp(): void
    {
        $this->fileMock = $this->createMock(File::class);
        $this->readerMock = $this->createMock(SmallFileReader::class);
        $this->factoryMock = $this->createMock(FileReadStrategyFactory::class);

        $this->decorator = new UnixDecorator($this->factoryMock);
    }


    public function testDecoratorReturnValidContent(): void
    {
        $this->factoryMock
            ->expects(self::once())
            ->method('getFileReaderByFile')
            ->willReturn($this->readerMock);

        $this->readerMock
            ->expects(self::exactly(2))
            ->method('hasNexLine')
            ->willReturn(true, false);

        $this->readerMock
            ->expects(self::once())
            ->method('readLine')
            ->willReturn($this->sampleContent);


        $content = $this->decorator->read($this->fileMock);
        $replacedSampleContent = str_replace(
            '\r\n',
            '\n',
            str_replace('\r', '\n', $this->sampleContent)
        );

        $this->assertSame($replacedSampleContent, $content);
    }
}