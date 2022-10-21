<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day17
{
    use ContentReader;

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();
        $containers = array_map(static fn(string $line): int => (int) $line, $lines);
        $solutions = $this->compute($containers, []);

        return (string) count($solutions);
    }

    public function partTwo(): string
    {
        $lines = $this->readInputAsLines();
        $containers = array_map(static fn(string $line): int => (int) $line, $lines);
        $solutions = $this->compute($containers, []);

        $minimumContainerAmount = min(array_map(fn(array $solution) => count($solution['solution']), $solutions));
        $numberOfSolutionsWithMinimumContainerAmount = count(
            array_filter(
                $solutions,
                fn (array $solution) => count($solution['solution']) === $minimumContainerAmount

            )
        );

        return (string) $numberOfSolutionsWithMinimumContainerAmount;
    }

    private function compute(array $containersLeft, array $stack): array
    {
        $stackSum = array_sum($stack);

        if (count($containersLeft) > 0) {
            // Tree pruning
            if ($stackSum > 150) {
                return [];
            }

            $container = array_shift($containersLeft);
            return array_merge($this->compute($containersLeft, $stack), $this->compute($containersLeft, array_merge($stack, [$container])));
        }

        if ($stackSum != 150) {
            return [];
        }

        return [['solution' => $stack]];
    }
}