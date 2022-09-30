<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015\Concerns;

trait ContentReader
{
    protected function readFile(string $fileName): string
    {
        $content = file_get_contents($fileName);

        return trim($content);
    }

    protected function readInputForDay(int $day): string
    {
        return $this->readFile(__DIR__ . "/../../inputs/day{$day}.txt");
    }

    protected function readInput(): string
    {
        // Derive the day from the class name (using late static binding)
        return $this->readInputForDay((int) substr(static::class, -2));
    }
}