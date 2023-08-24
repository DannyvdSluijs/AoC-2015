<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day10 implements PuzzleDay
{
    use ContentReader;

    public function partOne(): string
    {
        $input = $this->readInput();

        for ($x = 0; $x < 50; $x++) {
            $count = 0;
            $output = '';
            $previous = $input[0];

            foreach (str_split($input) as $char) {
                if ($char !== $previous) {
                    $output .= $count . $previous;
                    $previous = $char;
                    $count = 1;

                    continue;
                }

                $count++;
            }

            $output .= $count . $previous;

            $input = $output;
        }

        return (string) strlen($output);
    }

    public function partTwo(): string
    {
        return '';
    }
}