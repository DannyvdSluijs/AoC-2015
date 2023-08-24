<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day06 implements PuzzleDay
{
    use ContentReader;

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();
        $instructions = $this->parseInput($lines);

        $gridSize = 1000;
        $count = 0;
        for ($x = 0; $x <= $gridSize; $x++) {
            $matchingX = array_filter($instructions, fn(\stdClass $i): bool => $x >= $i->x1 && $x <= $i->x2);
            if (count($matchingX) === 0) {
                continue;
            }
            for ($y = 0; $y <= $gridSize; $y++) {

                $matchingXY = array_filter($matchingX, fn(\stdClass $i) => $y >= $i->y1 && $y <= $i->y2);
                if (count($matchingXY) === 0) {
                    continue;
                }

                $toggle = false;
                while (true) {
                    if ($matchingXY === []) {
                        if ($toggle) {
                            $count++;
                        }
                        break;
                    }
                    $latest = array_pop($matchingXY);

                    if ($latest->type === 'toggle') {
                        $toggle = !$toggle;
                    }
                    if ($latest->type === 'on') {
                        if (!$toggle) {
                            $count++;
                        }
                        break;
                    }
                    if ($latest->type === 'off') {
                        if ($toggle) {
                            $count++;
                        }
                        break;
                    }
                }
            }
        }

        return (string) $count;
    }

    public function partTwo(): string
    {
        $lines = $this->readInputAsLines();
        $instructions = $this->parseInput($lines);

        $gridSize = 1000;
        $totalBrightness = 0;
        for ($x = 0; $x <= $gridSize; $x++) {
            $matchingX = array_filter($instructions, fn(\stdClass $i): bool => $x >= $i->x1 && $x <= $i->x2);
            if (count($matchingX) === 0) {
                continue;
            }
            for ($y = 0; $y <= $gridSize; $y++) {
                $matchingXY = array_filter($matchingX, fn(\stdClass $i) => $y >= $i->y1 && $y <= $i->y2);
                if (count($matchingXY) === 0) {
                    continue;
                }

                $brightness = 0;
                while (count($matchingXY)) {
                    $instruction = array_shift($matchingXY);
                    $brightness = match ($instruction->type) {
                        'on' => $brightness + 1,
                        'off' => max($brightness - 1, 0),
                        'toggle' => $brightness + 2,
                        default => throw new \InvalidArgumentException("No case for {$instruction->type}"),
                    };
                }
                $totalBrightness += $brightness;
            }
        }

        return (string) $totalBrightness;
    }

    /**
     * @param array<int, string> $lines
     * @return array<int, \stdClass>
     */
    public function parseInput(array $lines): array
    {
        $instructions = [];
        foreach ($lines as $line) {
            $line = str_replace(',', ' ', $line);
            $parts = explode(' ', $line);
            $instructions[] = match ($parts[0]) {
                'toggle' => (object)[
                    'type' => $parts[0],
                    'x1' => (int)$parts[1],
                    'y1' => (int)$parts[2],
                    'x2' => (int)$parts[4],
                    'y2' => (int)$parts[5],
                ],
                'turn' => (object)[
                    'type' => $parts[1],
                    'x1' => (int)$parts[2],
                    'y1' => (int)$parts[3],
                    'x2' => (int)$parts[5],
                    'y2' => (int)$parts[6],
                ],
                default => throw new \InvalidArgumentException("No case for {$parts[0]}"),
            };
        }
        return $instructions;
    }
}