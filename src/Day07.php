<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day07
{
    use ContentReader;

    /** @var array< string, string> */
    private array $wires = [];
    /** @var array<string, string> */
    private array $wireCache = [];

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();

        foreach ($lines as $line) {
            [$signal, $wire] = explode(' -> ', $line);
            $this->wires[$wire] = $signal;
        }

        return (string)  $this->resolveWire('a');
    }

    public function partTwo(): string
    {
        $content = $this->readInput();
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            [$signal, $wire] = explode(' -> ', $line);
            $this->wires[$wire] = $signal;
        }

        $this->wires['b'] = (string) $this->resolveWire('a');
        $this->wireCache = [];

        return (string) $this->resolveWire('a');
    }

    private function resolveWire(string $wire): int
    {
        if (is_numeric($wire)) {
            return (int) $wire;
        }

        if (array_key_exists($wire, $this->wireCache)) {
            return $this->wireCache[$wire];
        }

        $inputs = explode(' ', (string) $this->wires[$wire]);
        $numberOfInputs = count($inputs);

        $result =  match ($numberOfInputs) {
            1 => is_numeric($inputs[0]) ? (int)$inputs[0] : $this->resolveWire($inputs[0]),
            2 => 65535 - $this->resolveWire($inputs[1]),
            3 => match ($inputs[1]) {
                'AND' => $this->resolveWire($inputs[0]) & $this->resolveWire($inputs[2]),
                'OR' => $this->resolveWire($inputs[0]) | $this->resolveWire($inputs[2]),
                'LSHIFT' => $this->resolveWire($inputs[0]) << (int)$inputs[2],
                'RSHIFT' => $this->resolveWire($inputs[0]) >> (int)$inputs[2],
                default => throw new \RuntimeException("Missing case for {$inputs[1]}"),
            },
            default => throw new \RuntimeException("Missing case for $numberOfInputs inputs"),
        };


        $this->wireCache[$wire] = $result;
        return $result;
    }
}