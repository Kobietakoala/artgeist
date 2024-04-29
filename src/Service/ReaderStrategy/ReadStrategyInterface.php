<?php declare(strict_types=1);

namespace App\Service\ReaderStrategy;

interface ReadStrategyInterface
{
    public function readLine(): ?string;

    public function hasNexLine(): bool;
}