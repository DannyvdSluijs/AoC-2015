<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day15 implements PuzzleDay
{
    use ContentReader;

    private array $ingredients;

    public function partOne(): string
    {
        $this->parseIngredients();

        $maxScore = 0;
        for ($a = 1; $a <= 97; $a++) {
            for ($b = 1; $a + $b <= 98; $b++) {
                for ($c = 1; $a + $b + $c <= 99; $c++) {
                    for ($d = 100 - $a - $b - $c; $a + $b + $c + $d <= 100; $d++) {
                        $score = $this->calculateScore($a, $b, $c, $d);
                        $maxScore = max($score, $maxScore);
                    }
                }
            }
        }
        return (string) $maxScore;
    }

    public function partTwo(): string
    {
        $this->parseIngredients();

        $maxScore = 0;
        for ($a = 1; $a <= 97; $a++) {
            for ($b = 1; $a + $b <= 98; $b++) {
                for ($c = 1; $a + $b + $c <= 99; $c++) {
                    for ($d = 100 - $a - $b - $c; $a + $b + $c + $d <= 100; $d++) {
                        $score = $this->calculateScore($a, $b, $c, $d, true);
                        $maxScore = max($score, $maxScore);
                    }
                }
            }
        }
        return (string) $maxScore;
    }

    private function calculateScore(int $a, int $b, int $c, int $d, bool $calorieCheck = false): int
    {
        $capacity = max($this->ingredients[0]->capacity * $a + $this->ingredients[1]->capacity * $b + $this->ingredients[2]->capacity * $c + $this->ingredients[3]->capacity * $d, 0);
        $durability = max($this->ingredients[0]->durability * $a + $this->ingredients[1]->durability * $b + $this->ingredients[2]->durability * $c + $this->ingredients[3]->durability * $d, 0);
        $flavor = max($this->ingredients[0]->flavor * $a + $this->ingredients[1]->flavor * $b + $this->ingredients[2]->flavor * $c + $this->ingredients[3]->flavor * $d, 0);
        $texture = max($this->ingredients[0]->texture * $a + $this->ingredients[1]->texture * $b + $this->ingredients[2]->texture * $c + $this->ingredients[3]->texture * $d, 0);
        $calories = max($this->ingredients[0]->calories * $a + $this->ingredients[1]->calories * $b + $this->ingredients[2]->calories * $c + $this->ingredients[3]->calories * $d, 0);

        if ($calorieCheck) {
            return $calories === 500 ? $capacity * $durability * $flavor * $texture : 0;
        }

        return $capacity * $durability * $flavor * $texture;
    }

    public function parseIngredients(): void
    {
        $lines = $this->readInputAsLines();
        $this->ingredients = [];
        foreach ($lines as $line) {
            $line = str_replace([':', ','], '', $line);
            $parts = explode(' ', $line);
            $this->ingredients[] = (object)[
                'name' => $parts[0],
                'capacity' => (int)$parts[2],
                'durability' => (int)$parts[4],
                'flavor' => (int)$parts[6],
                'texture' => (int)$parts[8],
                'calories' => (int)$parts[10],
            ];
        }
    }
}