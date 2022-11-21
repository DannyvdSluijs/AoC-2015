<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day21
{
    use ContentReader;

    /** @var array<int, \stdClass>  */
    private array $weapons = [];
    /** @var array<int, \stdClass>  */
    private array $armors = [];
    /** @var array<int, \stdClass>  */
    private array $rings = [];

    public function __construct()
    {
        $this->weapons = [
            (object) ['name' => 'dagger', 'cost' => 8, 'damage' => 4, 'armor' => 0],
            (object) ['name' => 'shortsword', 'cost' => 10, 'damage' => 5, 'armor' => 0],
            (object) ['name' => 'warhammer', 'cost' => 25, 'damage' => 6, 'armor' => 0],
            (object) ['name' => 'longsword', 'cost' => 40, 'damage' => 7, 'armor' => 0],
            (object) ['name' => 'greataxe', 'cost' => 74, 'damage' => 8, 'armor' => 0],
        ];
        $this->armors = [
            (object) ['name' => 'leather', 'cost' => 13, 'damage' => 0, 'armor' => 1],
            (object) ['name' => 'chainmill', 'cost' => 31, 'damage' => 0, 'armor' => 2],
            (object) ['name' => 'splintmail', 'cost' => 53, 'damage' => 0, 'armor' => 3],
            (object) ['name' => 'bandedmail', 'cost' => 75, 'damage' => 0, 'armor' => 4],
            (object) ['name' => 'platemail', 'cost' => 102, 'damage' => 0, 'armor' => 5],
            (object) ['name' => 'none', 'cost' => 0, 'damage' => 0, 'armor' => 0],
        ];
        $this->rings = [
            (object) ['name' => 'damage1', 'cost' => 25, 'damage' => 1, 'armor' => 0],
            (object) ['name' => 'damage2', 'cost' => 50, 'damage' => 2, 'armor' => 0],
            (object) ['name' => 'damage3', 'cost' => 100, 'damage' => 3, 'armor' => 0],
            (object) ['name' => 'defense1', 'cost' => 20, 'damage' => 0, 'armor' => 1],
            (object) ['name' => 'defense2', 'cost' => 40, 'damage' => 0, 'armor' => 2],
            (object) ['name' => 'defense3', 'cost' => 80, 'damage' => 0, 'armor' => 3],
            (object) ['name' => 'none', 'cost' => 0, 'damage' => 0, 'armor' => 0],
        ];
    }

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();
        $values = array_map(function (string $line) {
            $parts = explode(' ', $line);
            return (int) array_pop($parts);
        }, $lines);

        $boss = (object) [
            'hitpoints' => $values[0],
            'damage' => $values[1],
            'armor' => $values[2],
        ];
        $me = (object) [
            'hitpoints' => 100,
            'damage' => 0,
            'armor' => 0,
        ];

        $winWithLowestCost = 9999;
        foreach ($this->weapons as $weapon) {
            foreach ($this->armors as $armor) {
                for ($a = 0; $a <= 6; $a++) {
                    for ($b = 0; $b <= 6; $b++) {
                        if ($a === $b && $this->rings[$a]->name !== 'none') {
                            continue;
                        }

                        $totalCost = $weapon->cost + $armor->cost + $this->rings[$a]->cost  + $this->rings[$b]->cost;
                        if ($totalCost > $winWithLowestCost) {
                            continue;
                        }

                        $me->armor = $weapon->armor + $armor->armor + $this->rings[$a]->armor + $this->rings[$b]->armor;
                        $me->damage = $weapon->damage + $armor->damage + $this->rings[$a]->damage + $this->rings[$b]->damage;
                        if ($this->wouldWin($me, $boss)) {
                            $winWithLowestCost = $totalCost;
                        }
                    }
                }
            }
        }

        return (string) $winWithLowestCost;
    }

    public function partTwo(): string
    {
        $lines = $this->readInputAsLines();
        $values = array_map(function (string $line) {
            $parts = explode(' ', $line);
            return (int) array_pop($parts);
        }, $lines);

        $boss = (object) [
            'hitpoints' => $values[0],
            'damage' => $values[1],
            'armor' => $values[2],
        ];
        $me = (object) [
            'hitpoints' => 100,
            'damage' => 0,
            'armor' => 0,
        ];

        $looseWithHighestCost = 0;
        foreach ($this->weapons as $weapon) {
            foreach ($this->armors as $armor) {
                for ($a = 0; $a <= 6; $a++) {
                    for ($b = 0; $b <= 6; $b++) {
                        if ($a === $b && $this->rings[$a]->name !== 'none') {
                            continue;
                        }

                        $totalCost = $weapon->cost + $armor->cost + $this->rings[$a]->cost  + $this->rings[$b]->cost;
                        if ($totalCost < $looseWithHighestCost) {
                            continue;
                        }

                        $me->armor = $weapon->armor + $armor->armor + $this->rings[$a]->armor + $this->rings[$b]->armor;
                        $me->damage = $weapon->damage + $armor->damage + $this->rings[$a]->damage + $this->rings[$b]->damage;
                        if (!$this->wouldWin($me, $boss)) {
                            $looseWithHighestCost = $totalCost;
                        }
                    }
                }
            }
        }

        return (string) $looseWithHighestCost;
    }

    private function wouldWin(object $me, object $boss): bool
    {
        $meClone = clone $me;
        $bossClone = clone $boss;

        while (true) {
            $damage = max($meClone->damage - $bossClone->armor, 1);
            $bossClone->hitpoints -= $damage;

            if ($bossClone->hitpoints <= 0) {
                return true;
            }

            $damage = max($bossClone->damage - $meClone->armor, 1);
            $meClone->hitpoints -= $damage;
            if ($meClone->hitpoints <= 0) {
                return false;
            }
        }
    }

}