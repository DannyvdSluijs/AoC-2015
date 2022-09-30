<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day04
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInputForDay(4);
        $number = 1;
        while (true) {
            $hash = md5($content . $number);
            if (str_starts_with($hash, '00000')) {
                return (string) $number;
            }
            $number++;
        }
    }

    public function partTwo(): string
    {
        $content = $this->readInputForDay(4);
        $number = 1;
        while (true) {
            $hash = md5($content . $number);
            if (str_starts_with($hash, '000000')) {
                return (string) $number;
            }
            $number++;
        }
    }
}