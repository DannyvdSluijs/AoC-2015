<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day12
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInput();
        $object = json_decode($content, null, 512, JSON_THROW_ON_ERROR);
        $sum = $this->sum($object);

        return (string) $sum;
    }

    public function partTwo(): string
    {
        $content = $this->readInput();
        $object = json_decode($content, null, 512, JSON_THROW_ON_ERROR);
        $sum = $this->sum($object, true);

        return (string) $sum;
    }

    private function sum(mixed $object, bool $skipRedOnObject = false): int
    {
        if (is_object($object) && in_array('red', (array) $object)) {
            return 0;
        }

        $sum = 0;
        foreach ($object as $value) {
            if (is_numeric($value)) {
                $sum += (int)$value;
            }

            if (is_array($value) || is_object($value)) {
                $sum += $this->sum($value, $skipRedOnObject);
            }
        }

        return $sum;
    }
}