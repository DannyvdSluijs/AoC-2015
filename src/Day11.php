<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day11 implements PuzzleDay
{
    use ContentReader;


    public function partOne(): string
    {
        $password = $this->readInput();
        $chars = str_split($password);

        $solution = [
            $chars[0],
            $chars[1],
            $chars[2],
            $chars[3],
            $chars[3],
            chr(ord($chars[3]) + 1),
            chr(ord($chars[3]) + 2),
            chr(ord($chars[3]) + 2),
        ];

        return implode('', $solution);
    }

    public function partTwo(): string
    {
        $password = $this->partOne();
        $chars = str_split($password);
        $solution = [
            $chars[0],
            $chars[1],
            chr(ord($chars[2]) + 1),
            'a',
            'a',
            'b',
            'c',
            'c'
        ];

        return implode('', $solution);
    }
}