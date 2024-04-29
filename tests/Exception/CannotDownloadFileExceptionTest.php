<?php declare(strict_types=1);

namespace Exception;

use App\Exception\CannotDownloadFileException;
use PHPUnit\Framework\TestCase;

class CannotDownloadFileExceptionTest extends TestCase
{
    public function testExceptionHasValidMessage(): void
    {
        $exception = new CannotDownloadFileException();

        $this->assertSame('Cannot download file.', $exception->getMessage());
    }
}