<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day16
{
    use ContentReader;

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();
        $aunts = [];
        foreach ($lines as $line) {
            $line = str_replace(',', ':', $line);
            $parts = explode(':', $line);
            $partsCount = count($parts);
            $aunt = (object) ['number' => substr($parts[0], 4)];
            for($i = 1; $i < $partsCount; $i += 2) {
                $property = trim($parts[$i]);
                $value = (int) $parts[$i + 1];
                $aunt->$property = $value;
            }

            $aunts[$aunt->number] = $aunt;
        }

        $aunts = $this->filter($aunts, 'children', 3);
        $aunts = $this->filter($aunts, 'cats', 7);
        $aunts = $this->filter($aunts, 'samoyeds', 2);
        $aunts = $this->filter($aunts, 'pomeranians', 3);
        $aunts = $this->filter($aunts, 'akitas', 0);
        $aunts = $this->filter($aunts, 'vizslas', 0);
        $aunts = $this->filter($aunts, 'goldfish', 5);
        $aunts = $this->filter($aunts, 'trees', 3);
        $aunts = $this->filter($aunts, 'cars', 2);
        $aunts = $this->filter($aunts, 'perfumes', 1);

        return (string) array_shift($aunts)->number;
    }

    public function partTwo(): string
    {
        $lines = $this->readInputAsLines();
        $aunts = [];
        foreach ($lines as $line) {
            $line = str_replace(',', ':', $line);
            $parts = explode(':', $line);
            $partsCount = count($parts);
            $aunt = (object) ['number' => substr($parts[0], 4)];
            for($i = 1; $i < $partsCount; $i += 2) {
                $property = trim($parts[$i]);
                $value = (int) $parts[$i + 1];
                $aunt->$property = $value;
            }

            $aunts[$aunt->number] = $aunt;
        }

        $aunts = $this->filter($aunts, 'children', 3);
        $aunts = $this->filter($aunts, 'cats', 7, 'greater');
        $aunts = $this->filter($aunts, 'samoyeds', 2);
        $aunts = $this->filter($aunts, 'pomeranians', 3, 'fewer');
        $aunts = $this->filter($aunts, 'akitas', 0);
        $aunts = $this->filter($aunts, 'vizslas', 0);
        $aunts = $this->filter($aunts, 'goldfish', 5, 'fewer');
        $aunts = $this->filter($aunts, 'trees', 3, 'greater');
        $aunts = $this->filter($aunts, 'cars', 2);
        $aunts = $this->filter($aunts, 'perfumes', 1);


        return (string) array_shift($aunts)->number;
    }

    private function filter(array $aunts, string $property, int $number, string $comparing = 'equal'): array
    {
        foreach ($aunts as $aunt) {
            $clear = match ($comparing) {
                'equal' => isset($aunt->$property) && $aunt->$property !== $number,
                'greater' => isset($aunt->$property) && $aunt->$property <= $number,
                'fewer' => isset($aunt->$property) && $aunt->$property >= $number,
                default => throw new \InvalidArgumentException("No case for {$comparing}"),
            };

            if ($clear) {
                unset($aunts[$aunt->number]);
            }
        }

        return $aunts;
    }

}