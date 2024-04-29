<?php declare(strict_types=1);

namespace App\Exception;

use Exception;
class FileDoesntExistException extends Exception
{
    protected $message = 'File doesn\'t exist.';
}