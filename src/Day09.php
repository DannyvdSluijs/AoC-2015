<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day09 implements PuzzleDay
{
    use ContentReader;

    /** @var array<int, /stdClass> */
    private array $edges = [];
    /** @var array<int, string> */
    private array $nodes = [];
    /** @var array<int, /stdClass> */
    private array $results = [];

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();
        foreach ($lines as $line) {
            $parts = explode(' ', $line);
            $this->edges[] = (object) ['from' => $parts[0], 'to' => $parts[2], 'weight' => (int) $parts[4]];
            $this->edges[] = (object) ['from' => $parts[2], 'to' => $parts[0], 'weight' => (int) $parts[4]];
            $this->nodes[] = $parts[0];
            $this->nodes[] = $parts[2];
        }
        $this->nodes = array_unique($this->nodes);

        foreach ($this->nodes as $from) {
            $toVisit = array_filter($this->nodes, fn (string $node) => $node !== $from);
            $this->travel($toVisit, [$from], 0);
        }

        usort($this->results, fn(\stdClass $left, \stdClass $right): int => $left->weight <=> $right->weight);
        $shortest = array_shift($this->results);

        return (string) $shortest->weight;
    }

    public function partTwo(): string
    {
        $lines = $this->readInputAsLines();
        foreach ($lines as $line) {
            $parts = explode(' ', $line);
            $this->edges[] = (object) ['from' => $parts[0], 'to' => $parts[2], 'weight' => (int) $parts[4]];
            $this->edges[] = (object) ['from' => $parts[2], 'to' => $parts[0], 'weight' => (int) $parts[4]];
            $this->nodes[] = $parts[0];
            $this->nodes[] = $parts[2];
        }
        $this->nodes = array_unique($this->nodes);

        foreach ($this->nodes as $from) {
            $toVisit = array_filter($this->nodes, fn (string $node) => $node !== $from);
            $this->travel($toVisit, [$from], 0);
        }

        usort($this->results, fn(\stdClass $left, \stdClass $right): int => $left->weight <=> $right->weight);
        $shortest = array_pop($this->results);

        return (string) $shortest->weight;
    }

    private function travel(array $toVisit, array $path, int $currentWeight): void
    {
        if ($toVisit === []) {
            $this->results[] =  (object) ['path' => $path, 'weight' => $currentWeight];
            return;
        }

        $from = $path[array_key_last($path)];
        foreach ($toVisit as $to) {
            $weight = $this->findWeight($from, $to);

            $newToVisit = array_filter($toVisit, fn(string $node) => $node !== $to);
            $newPath = $path;
            $newPath[] = $to;
            $newCurrentWeight = $currentWeight + $weight;

            $this->travel($newToVisit, $newPath, $newCurrentWeight);
        }
    }

    private function findWeight(mixed $from, mixed $to): int
    {
        $matches = array_filter($this->edges, fn (\stdClass $edge) => $edge->from === $from && $edge->to === $to);
        $match = array_shift($matches);

        return $match->weight;
    }
}