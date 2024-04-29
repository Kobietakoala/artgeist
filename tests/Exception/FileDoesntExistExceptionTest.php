<?php declare(strict_types=1);

namespace Exception;

use App\Exception\FileDoesntExistException;
use PHPUnit\Framework\TestCase;

class FileDoesntExistExceptionTest extends TestCase
{
    public function testExceptionHasValidMessage(): void
    {
        $exception = new FileDoesntExistException();

        $this->assertSame('File doesn\'t exist.', $exception->getMessage());
    }
}