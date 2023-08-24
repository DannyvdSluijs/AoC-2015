<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day03 implements PuzzleDay
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInputForDay(3);
        $moves = str_split($content);

        $pos = (object)['x' => 0, 'y' => 0];
        $deliveredAt = ['0,0' => 1];

        foreach ($moves as $move) {
            $this->move($move, $pos);
            $deliveredAt = $this->addDelivery($pos, $deliveredAt);
        }

        $result = array_filter($deliveredAt, static fn($i) => $i >= 1);

        return (string) count($result);
    }

    public function partTwo(): string
    {
        $content = $this->readInputForDay(3);
        $moves = str_split($content);

        $santaPos = (object)['x' => 0, 'y' => 0];
        $robotPos = (object)['x' => 0, 'y' => 0];
        $deliveredAt = ['0,0' => 2];

        $size = count($moves);
        for ($x = 0; $x < $size; $x++) {
            $this->move($moves[$x], $santaPos);
            $deliveredAt = $this->addDelivery($santaPos, $deliveredAt);

            $x++;

            $this->move($moves[$x], $robotPos);
            $deliveredAt = $this->addDelivery($robotPos, $deliveredAt);
        }

        $result = array_filter($deliveredAt, static fn($i) => $i >= 1);

        return (string) count($result);
    }

    private function move(string $move, \stdClass $position): void
    {
        match ($move) {
            '^' => $position->y++,
            '>' => $position->x++,
            'v' => $position->y--,
            '<' => $position->x--,
            default => throw new \InvalidArgumentException(sprintf('No case for %s', $move)),
        };
    }

    private function getPositionKey(\stdClass $position): string
    {
        return $position->x . ',' . $position->y;
    }

    /**
     * @param array<string, int> $currentDeliveries
     * @return array<string, int>
     */
    private function addDelivery(\stdClass $position, array $currentDeliveries): array
    {
        $key = $this->getPositionKey($position);
        if (!array_key_exists($key, $currentDeliveries)) {
            $currentDeliveries[$key] = 0;
        }

        $currentDeliveries[$key]++;
        printf("Delivered present at %s, total presents is %d\r\n", $key, $currentDeliveries[$key]);
        return $currentDeliveries;
    }
}