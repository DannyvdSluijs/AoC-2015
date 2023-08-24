<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day20 implements PuzzleDay
{
    use ContentReader;

    public function partOne(): string
    {
        $target = $this->readInputAsNumber();
        $houseNumber = 1;

        while (true) {
            $dividers = $this->getDividers($houseNumber);
            $sum = array_sum($dividers) * 10;

            if ($sum >= $target) {
                break;
            }

            if ($houseNumber % 10_000 === 0) {
                printf("House %d got %d presents.\r\n", $houseNumber, $sum);
            }


            $houseNumber++;
        }
        return (string) $houseNumber;
    }

    public function partTwo(): string
    {
        $target = $this->readInputAsNumber();
        $houseNumber = 1;

        while (true) {
            $dividers = $this->getDividers($houseNumber);
            $dividers = array_filter($dividers, fn($d) => $d * 50 >= $houseNumber);
            $sum = array_sum($dividers) * 11;

            if ($sum >= $target) {
                break;
            }

            if ($houseNumber % 10_000 === 0) {
                printf("House %d got %d presents.\r\n", $houseNumber, $sum);
            }


            $houseNumber++;
        }
        return (string) $houseNumber;
    }

    /** @return array<int, int> */
    private function getDividers(int $houseNumber): array
    {
        $flooredSquareRoot = floor(sqrt($houseNumber));
        $dividers = [1, $houseNumber];


        for ($x = 2; $x <= $flooredSquareRoot; $x++) {
            if ($houseNumber % $x === 0) {
                $dividers[] = $x;
                $dividers[] = $houseNumber / $x;
            }
        }

        return array_unique($dividers);
    }
}