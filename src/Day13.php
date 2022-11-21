<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;
use stdClass;

class Day13
{
    use ContentReader;

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();
        $inputs = [];
        foreach ($lines as $line) {
            $line = str_replace('.', '', $line);
            $parts = explode(' ', $line);
            $parts[3] = (int) $parts[3];

            $inputs[] = (object) [
                'person' => $parts[0],
                'effect' => (int) ($parts[2] === 'gain' ? $parts[3] : -$parts[3]),
                'other' => $parts[10]
            ];
        }

        $persons = array_map(fn(stdClass $input) => $input->person, $inputs);
        $persons = array_unique($persons);
        $personCount = count($persons);

        $possibilities = $this->permutations($persons);
        $changes = [];
        foreach ($possibilities as $possibility) {
            $change = 0;
            for ($x = 0; $x < $personCount; $x++) {
                // Person left
                $matches = array_filter($inputs, fn (stdClass $input) => $input->person === $possibility[$x] && $input->other === $possibility[($x + 1) % $personCount]);
                $match = array_pop($matches);
                $change += $match->effect;
                // Inverse
                $matches = array_filter($inputs, fn (stdClass $input) => $input->person === $possibility[($x + 1) % $personCount] && $input->other === $possibility[$x]);
                $match = array_pop($matches);
                $change += $match->effect;
            }

            $changes[] = (object) ['change' => $change, 'possibility' => $possibility];
        }

        usort($changes, fn (stdClass $left, stdClass $right): int => $left->change <=> $right->change);
        $most = array_pop($changes);

        return (string) $most->change;
    }

    public function partTwo(): string
    {
        // @todo improve speed
        $lines = $this->readInputAsLines();
        $inputs = [];
        foreach ($lines as $line) {
            $line = str_replace('.', '', $line);
            $parts = explode(' ', $line);
            $parts[3] = (int) $parts[3];

            $inputs[] = (object) [
                'person' => $parts[0],
                'effect' => (int) ($parts[2] === 'gain' ? $parts[3] : -$parts[3]),
                'other' => $parts[10]
            ];
        }

        $persons = array_map(fn(stdClass $input) => $input->person, $inputs);
        $persons = array_unique($persons);
        $personCount = count($persons);

        foreach ($persons as $person) {
            $inputs[] = (object) [
                'person' => $person,
                'effect' => 0,
                'other' => 'me'
            ];
            $inputs[] = (object) [
                'person' => 'me',
                'effect' => 0,
                'other' => $person
            ];
        }
        $persons[] = 'me';
        $personCount++;

        $possibilities = $this->permutations($persons);
        $changes = [];
        foreach ($possibilities as $possibility) {
            $change = 0;
            for ($x = 0; $x < $personCount; $x++) {
                // Person left
                $matches = array_filter($inputs, fn (stdClass $input) => $input->person === $possibility[$x] && $input->other === $possibility[($x + 1) % $personCount]);
                $match = array_pop($matches);
                $change += $match->effect;
                // Inverse
                $matches = array_filter($inputs, fn (stdClass $input) => $input->person === $possibility[($x + 1) % $personCount] && $input->other === $possibility[$x]);
                $match = array_pop($matches);
                $change += $match->effect;
            }

            $changes[] = (object) ['change' => $change, 'possibility' => $possibility];
        }

        usort($changes, fn (stdClass $left, stdClass $right): int => $left->change <=> $right->change);
        $most = array_pop($changes);

        return (string) $most->change;
    }

    private function permutations(array $persons, array $stack = []): array
    {
        static $possibilities = [];
        if ($persons === []) {
            $possibilities[] = $stack;
            return [];
        }

        foreach ($persons as $person) {
            $this->permutations(
                array_filter($persons, fn(string $p) => $p !== $person),
                array_merge($stack, [$person])
            );
        }
        return $possibilities;
    }
}