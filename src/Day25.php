<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day25 implements PuzzleDay
{
    use ContentReader;

    public function partOne(): string
    {
        $input = $this->readInput();
        $parts = explode(' ', $input);
        $row = (int) $parts[16];
        $column = (int) $parts[18];

        $diagonals = [];
        $diagonals[1] = ['min' => 1, 'max' => 1];
        $highest = 1;
        $diagonalNeeded = $row + $column - 1;
        for ($d = 2; $d <= $diagonalNeeded; $d++) {
            $diagonals[$d] = ['min' => $highest + 1, 'max' => $highest + $d];
            $highest += $d;
        }

        $turns = $diagonals[$diagonalNeeded]['min'] + $column - 1;

        $value = 20_151_125;;
        for ($x = 1; $x < $turns; $x++) {
            $value = $value * 252533 % 33_554_393;;
        }

        return (string) $value;
    }

    public function partTwo(): string
    {
        return '';
    }
}