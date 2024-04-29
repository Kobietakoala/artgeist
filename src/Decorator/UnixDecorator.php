<?php declare(strict_types=1);

namespace App\Decorator;

use App\Service\FileReader\FileReader;

class UnixDecorator extends FileReader
{
    /**
     * @return string|null
     */
    protected function readLine(): ?string
    {
        $line = parent::readLine();

        return str_replace('\r\n', '\n', str_replace('\r', '\n', $line));
    }
}