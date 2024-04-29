<?php declare(strict_types=1);

namespace App\Exception;

use Exception;

class WrongFileExtensionException extends Exception
{
    protected $message = 'Wrong file extension.';
}