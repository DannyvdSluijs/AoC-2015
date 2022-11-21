<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day23
{
    use ContentReader;

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();
        $instructions = [];
        $register = ['a' => 0, 'b' => 0];
        foreach ($lines as $line) {
            $line = str_replace(',', '', $line);
            $parts = explode(' ', $line);
            $instructions[] = (object) [
                'instruction' => $parts[0],
                'register' => $parts[1],
                'offset' => (int) ($parts[2] ?? null)
            ];
        }

        $pointer = 0;
        $numberInstructions = count($instructions);
        while($pointer < $numberInstructions) {
            $current = $instructions[$pointer];
            echo implode(' ', [$pointer, $current->instruction, $current->register, $current->offset]) . ' => ';

            switch ($current->instruction) {
                case 'hlf':
                    $register[$current->register] /= 2;
                    $pointer++;
                    continue 2;
                case 'tpl':
                    $register[$current->register] *= 3;
                    $pointer++;
                    continue 2;
                case 'inc':
                    $register[$current->register]++;
                    $pointer++;
                    continue 2;
                case 'jmp':
                    $pointer += $current->register;
                    continue 2;
                case 'jie':
                    if ($register[$current->register] % 2 === 0) {
                        $pointer += $current->offset;
                        continue 2;
                    }

                    $pointer++;
                    continue 2;
                case 'jio':
                    if ($register[$current->register] === 1) {
                        $pointer += $current->offset;
                        continue 2;
                    }

                    $pointer++;
                    continue 2;
            }
        }

        return (string) $register['b'];
    }

    public function partTwo(): string
    {
        $lines = $this->readInputAsLines();
        $instructions = [];
        $register = ['a' => 1, 'b' => 0];
        foreach ($lines as $line) {
            $line = str_replace(',', '', $line);
            $parts = explode(' ', $line);
            $instructions[] = (object) [
                'instruction' => $parts[0],
                'register' => $parts[1],
                'offset' => (int) ($parts[2] ?? null)
            ];
        }

        $pointer = 0;
        $numberInstructions = count($instructions);
        while($pointer < $numberInstructions) {
            $current = $instructions[$pointer];
            echo implode(' ', [$pointer, $current->instruction, $current->register, $current->offset]) . ' => ';

            switch ($current->instruction) {
                case 'hlf':
                    $register[$current->register] /= 2;
                    $pointer++;
                    continue 2;
                case 'tpl':
                    $register[$current->register] *= 3;
                    $pointer++;
                    continue 2;
                case 'inc':
                    $register[$current->register]++;
                    $pointer++;
                    continue 2;
                case 'jmp':
                    $pointer += $current->register;
                    continue 2;
                case 'jie':
                    if ($register[$current->register] % 2 === 0) {
                        $pointer += $current->offset;
                        continue 2;
                    }

                    $pointer++;
                    continue 2;
                case 'jio':
                    if ($register[$current->register] === 1) {
                        $pointer += $current->offset;
                        continue 2;
                    }

                    $pointer++;
                    continue 2;
            }
        }

        return (string) $register['b'];
    }
}