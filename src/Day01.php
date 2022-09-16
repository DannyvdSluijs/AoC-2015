<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

class Day01
{
    public function partOne(): string
    {
        $content = file_get_contents(__DIR__ . '/../inputs/day1.txt');

        $upOneFloorAmount  = substr_count($content, '(');
        $downOneFloorAmount  = substr_count($content, ')');

        return (string) ($upOneFloorAmount - $downOneFloorAmount);
    }

    public function partTwo(): string
    {
        $content = file_get_contents(__DIR__ . '/../inputs/day1.txt');
        $chars = str_split($content);
        $position = 0;
        $floor = 0;

        foreach ($chars as $char) {
            $position++;
            match ($char) {
                '(' => $floor++,
                ')' => $floor--,
            };

            if ($floor === -1) {
                return (string) $position;
            }
        }

        throw new \Exception('Unable to find a solution');
    }
}