<?php declare(strict_types=1);

namespace App\Exception;

use Exception;

class CannotDownloadFileException extends Exception
{
    protected $message = 'Cannot download file.';
}