<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day22 implements PuzzleDay
{
    use ContentReader;

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();
        $values = array_map(function (string $line) {
            $parts = explode(' ', $line);
            return (int) array_pop($parts);
        }, $lines);

        $state = (object) [
            'me' => (object) [
                'hitpoints' => 50,
                'mana' => 500,
                'armor' => 0,
                'activeSpells' => (object) [
                    'drain' => 0,
                    'shield' => 0,
                    'poison' => 0,
                    'recharge' => 0,

                ],
            ],
            'boss' => (object) [
                'hitpoints' => $values[0],
                'damage' => $values[1],
            ],
            'spells' => (object) [
                'missile' => (object) [
                    'cost' => 53,
                    'damage' => 4,
                    'heal' => 0,
                    'turns' => 0,
                ],
                'drain' => (object) [
                    'cost' => 73,
                    'damage' => 2,
                    'heal' => 2,
                    'turns' => 0,
                ],
                'shield' => (object) [
                    'cost' => 113,
                    'damage' => 0,
                    'heal' => 0,
                    'turns' => 6,
                ],
                'poison' => (object) [
                    'cost' => 173,
                    'damage' => 3,
                    'heal' => 0,
                    'turns' => 6,
                ],
                'recharge' => (object) [
                    'cost' => 229,
                    'damage' => 0,
                    'heal' => 0,
                    'turns' => 5,
                ],
            ],
            'spent' => 0,
            'move' => 'player',
        ];

        $min = PHP_INT_MAX;
        $moves = [$state];

        while ($state = array_shift($moves)) {
            $state->me->armor = ($state->me->activeSpells->shield-- > 0 ? 7 :0);
            if ($state->me->activeSpells->poison-- > 0)
                $state->boss->hitpoints -= 3;
            if ($state->me->activeSpells->recharge-- > 0)
                $state->me->mana += 101;

            if ($state->me->hitpoints <= 0 || $state->spent >= $min)
                continue;
            if ($state->boss->hitpoints <= 0) {
                $min = min($min, $state->spent);
                continue;
            }

            if ($state->move == 'boss') {
                $state->move = 'player';
                $state->me->hitpoints -= max(1, $state->boss->damage - $state->me->armor);

                $n = clone $state;
                $n->me = clone $n->me;
                $n->me->activeSpells = clone $n->me->activeSpells;
                $n->boss = clone $n->boss;

                array_unshift($moves, $n); // @todo add clone
            } else {
                $state->move = 'boss';
                foreach ($state->spells as $spell => $info) {
                    if ($info->cost >= $state->me->mana) continue;

                    $n = clone $state;
                    $n->me = clone $n->me;
                    $n->me->activeSpells = clone $n->me->activeSpells;
                    $n->boss = clone $n->boss;

                    $n->me->mana -= $info->cost;
                    $n->spent += $info->cost;

                    switch ($spell) {
                        case 'missile':
                        case 'drain':
                            $n->boss->hitpoints -= $info->damage;
                            $n->me->hitpoints += $info->heal;
                            break;
                        default:
                            if ($n->me->activeSpells->$spell > 0) continue 2;
                            $n->me->activeSpells->$spell = $info->turns;
                            break;
                    }

                    array_unshift($moves, $n);
                }
            }
        }


        return (string) $min;
    }

    public function partTwo(): string
    {
        $lines = $this->readInputAsLines();
        $values = array_map(function (string $line) {
            $parts = explode(' ', $line);
            return (int) array_pop($parts);
        }, $lines);

        $state = (object) [
            'me' => (object) [
                'hitpoints' => 50,
                'mana' => 500,
                'armor' => 0,
                'activeSpells' => (object) [
                    'drain' => 0,
                    'shield' => 0,
                    'poison' => 0,
                    'recharge' => 0,

                ],
            ],
            'boss' => (object) [
                'hitpoints' => $values[0],
                'damage' => $values[1],
            ],
            'spells' => (object) [
                'missile' => (object) [
                    'cost' => 53,
                    'damage' => 4,
                    'heal' => 0,
                    'turns' => 0,
                ],
                'drain' => (object) [
                    'cost' => 73,
                    'damage' => 2,
                    'heal' => 2,
                    'turns' => 0,
                ],
                'shield' => (object) [
                    'cost' => 113,
                    'damage' => 0,
                    'heal' => 0,
                    'turns' => 6,
                ],
                'poison' => (object) [
                    'cost' => 173,
                    'damage' => 3,
                    'heal' => 0,
                    'turns' => 6,
                ],
                'recharge' => (object) [
                    'cost' => 229,
                    'damage' => 0,
                    'heal' => 0,
                    'turns' => 5,
                ],
            ],
            'spent' => 0,
            'move' => 'player',
        ];

        $min = PHP_INT_MAX;
        $moves = [$state];

        while ($state = array_shift($moves)) {
            if ($state->move == 'player') {
                $state->me->hitpoints--;
            }

            $state->me->armor = ($state->me->activeSpells->shield-- > 0 ? 7 :0);
            if ($state->me->activeSpells->poison-- > 0)
                $state->boss->hitpoints -= 3;
            if ($state->me->activeSpells->recharge-- > 0)
                $state->me->mana += 101;

            if ($state->me->hitpoints <= 0 || $state->spent >= $min)
                continue;
            if ($state->boss->hitpoints <= 0) {
                $min = min($min, $state->spent);
                continue;
            }

            if ($state->move == 'boss') {
                $state->move = 'player';
                $state->me->hitpoints -= max(1, $state->boss->damage - $state->me->armor);

                $n = clone $state;
                $n->me = clone $n->me;
                $n->me->activeSpells = clone $n->me->activeSpells;
                $n->boss = clone $n->boss;

                array_unshift($moves, $n); // @todo add clone
            } else {
                $state->move = 'boss';
                foreach ($state->spells as $spell => $info) {
                    if ($info->cost >= $state->me->mana) continue;

                    $n = clone $state;
                    $n->me = clone $n->me;
                    $n->me->activeSpells = clone $n->me->activeSpells;
                    $n->boss = clone $n->boss;

                    $n->me->mana -= $info->cost;
                    $n->spent += $info->cost;

                    switch ($spell) {
                        case 'missile':
                        case 'drain':
                            $n->boss->hitpoints -= $info->damage;
                            $n->me->hitpoints += $info->heal;
                            break;
                        default:
                            if ($n->me->activeSpells->$spell > 0) continue 2;
                            $n->me->activeSpells->$spell = $info->turns;
                            break;
                    }

                    array_unshift($moves, $n);
                }
            }
        }


        return (string) $min;
    }
}