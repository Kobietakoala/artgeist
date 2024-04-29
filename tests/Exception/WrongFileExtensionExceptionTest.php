<?php declare(strict_types=1);

namespace Exception;

use App\Exception\WrongFileExtensionException;
use PHPUnit\Framework\TestCase;

class WrongFileExtensionExceptionTest extends TestCase
{
    public function testExceptionHasValidMessage(): void
    {
        $exception = new WrongFileExtensionException();

        $this->assertSame('Wrong file extension.', $exception->getMessage());
    }
}