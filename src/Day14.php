<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day14
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInput();
        $lines = explode("\n", $content);
        $deer = [];
        foreach ($lines as $line) {
            $parts = explode(' ', $line);

            $deer[$parts[0]] = (object) [
                'name' => $parts[0],
                'speed' => (int) $parts[3],
                'duration' => (int) $parts[6],
                'rest' => (int) $parts[13],
            ];
            $deer[$parts[0]]->total = $this->calculateDistance($deer[$parts[0]], 2503);
        }

        usort($deer, fn($d) => $d->total);
        $winner = array_pop($deer);

        return "{$winner->name}: {$winner->total}";
    }

    public function partTwo(): string
    {
        $content = $this->readInput();
        $lines = explode("\n", $content);
        $deer = [];
        foreach ($lines as $line) {
            $parts = explode(' ', $line);

            $deer[$parts[0]] = (object) [
                'name' => $parts[0],
                'speed' => (int) $parts[3],
                'duration' => (int) $parts[6],
                'rest' => (int) $parts[13],
                'points' => 0,
            ];
        }


        for ($i = 1; $i <= 2503; $i++) {
            $scores = $this->calculateDistances($deer, $i);
            $maxDistance = max(array_map(fn($d) => $d->distance, $deer));

            $winners = array_filter($deer, fn($d) => $d->distance === $maxDistance);
            array_walk($winners, fn($d) => $d->points++);
        }

        $winningDeerPoints = max(array_map(fn($d) => $d->points, $deer));
        return (string) $winningDeerPoints;
    }

    private function calculateDistance(object $deer, int $time): int
    {
        $completeCycleTime = $deer->duration + $deer->rest;

        $completePeriods = (int) floor($time / $completeCycleTime);
        $incompletePeriod = min($time % $completeCycleTime, $deer->duration);

//        var_dump($completeCycleTime, $completePeriods, $incompletePeriod);

        return $completePeriods * ($deer->speed * $deer->duration) + ($incompletePeriod * $deer->speed);
    }

    private function calculateDistances(array $deer, int $time): array
    {
        foreach ($deer as $d) {
            $d->distance = $this->calculateDistance($d, $time);
        }

        return $deer;
    }
}