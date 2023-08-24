<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day24 implements PuzzleDay
{
    use ContentReader;

    public function partOne(): string
    {
        $weights = $this->readInputAsLinesOfIntegers();
        rsort($weights);
        $sum = array_sum($weights);
        $each = $sum / 3;

        $solutions = $this->recursive($each, $weights);
        $smallest = min(array_map(static fn($a) => count($a), $solutions));
        $matchingSmallestSize = array_filter($solutions, static fn($a) => count($a) === $smallest);
        $quantumEntanglement = min(array_map(static fn($a) => array_reduce($a, static fn($carry, $item) => $carry * $item, 1), $matchingSmallestSize));

        return (string) $quantumEntanglement;
    }

    public function partTwo(): string
    {
        $weights = $this->readInputAsLinesOfIntegers();
        rsort($weights);
        $sum = array_sum($weights);
        $each = $sum / 4;

        $solutions = $this->recursive($each, $weights);
        $smallest = min(array_map(fn($a) => count($a), $solutions));
        $matchingSmallestSize = array_filter($solutions, fn($a) => count($a) === $smallest);
        $quantumEntanglement = min(array_map(fn($a) => array_reduce($a, fn($carry, $item) => $carry * $item, 1), $matchingSmallestSize));

        return (string) $quantumEntanglement;
    }

    /**
     * @param array<int, int> $weights
     * @param array<int, int> $stack
     * @return array<int, array<int, int>>
     */
    private function recursive(int $target, array $weights, array $stack = []): array
    {
        static $solutions= [];
        static $smallestAmountOfPackages = 999;

        $stackSum = array_sum($stack);
        $stackSize = count($stack);
        $weightsSum = array_sum($weights);
        if ($stackSum === $target) {
            $solutions[] = $stack;
            $smallestAmountOfPackages = min($smallestAmountOfPackages, count($stack));
            return [];
        }
        if ($stackSum > $target) {
            return [];
        }
        if ($weights === []) {
            return [];
        }
        if ($stackSize > $smallestAmountOfPackages) {
            return [];
        }
        if ($stackSum + $weightsSum < $target) {
            return [];
        }

        $next = array_shift($weights);

        $this->recursive($target, $weights, array_merge($stack, [$next]));
        $this->recursive($target, $weights, $stack);

        return $solutions;
    }
}