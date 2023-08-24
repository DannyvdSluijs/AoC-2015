<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day18 implements PuzzleDay
{
    use ContentReader;

    private const ON = '#';
    private const OFF = '.';

    public function partOne(): string
    {
        $grid = $this->readInputAsGridOfCharacters();
        printf("Initial state:\r\n");
        print $this->gridToString($grid);

        for ($step = 1; $step <=100; $step++) {
            $grid = $this->animate($grid);


            printf("After %d step:\r\n", $step);
            print $this->gridToString($grid);
        }

        $count = substr_count($this->gridToString($grid), self::ON);

        return (string) $count;
    }

    public function partTwo(): string
    {
        $grid = $this->readInputAsGridOfCharacters();
        $gridSize = count($grid);

        $grid[0][0] = self::ON;
        $grid[0][$gridSize -1] = self::ON;
        $grid[$gridSize -1][0] = self::ON;
        $grid[$gridSize -1][$gridSize-1] = self::ON;

        printf("Initial state:\r\n");
        print $this->gridToString($grid);

        for ($step = 1; $step <=100; $step++) {
            $grid = $this->animate($grid);
            $grid[0][0] = self::ON;
            $grid[0][$gridSize -1] = self::ON;
            $grid[$gridSize -1][0] = self::ON;
            $grid[$gridSize -1][$gridSize-1] = self::ON;

            printf("After %d step:\r\n", $step);
            print $this->gridToString($grid);
        }

        $count = substr_count($this->gridToString($grid), self::ON);

        // 2383 Is too high, 865 is too low
        return (string) $count;
    }

    private function gridToString(array $grid): string
    {
        return implode("\r\n", array_map(implode(...), $grid)) . PHP_EOL . PHP_EOL;
    }

    private function animate(mixed $grid): array
    {
        $copy = $grid;
        $xSize = count($grid);
        $ySize = count($grid[0]);
        for ($x = 0; $x < $xSize; $x++) {
            for ($y = 0; $y < $ySize; $y++) {
                $currentValue = $grid[$x][$y];

                // Always assume same value
                $newValue = $currentValue;
                $count = $this->getNeighboursCountInStateOn($x, $y, $grid);

                if ($currentValue === self::ON && $count !== 2 && $count !== 3) {
                    $newValue = self::OFF;
                }

                if ($currentValue === self::OFF && $count === 3) {
                    $newValue = self::ON;
                }

//                printf("%d,%d current: %s, new: %s\r\n", $x, $y, $currentValue, $newValue);
                $copy[$x][$y] = $newValue;
            }
        }

        return $copy;
    }

    private function getNeighboursCountInStateOn(int $x, int $y, mixed $grid): int
    {
        $count = 0;

        foreach ([-1, 0, 1] as $xOffset) {
            foreach ([-1, 0, 1] as $yOffset) {
                if ($xOffset === 0 && $yOffset === 0) {
                    continue;
                }

                $neighbourValue = $grid[$x + $xOffset][$y + $yOffset] ?? self::OFF;
                if ($neighbourValue === self::ON) {
                    $count++;
                }
            }
        }

//        printf("%d,%d count: %d\r\n", $x, $y, $count);
        return $count;
    }
}