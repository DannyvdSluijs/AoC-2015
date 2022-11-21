<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day02
{
    use ContentReader;

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();

        $totalPaper = 0;
        foreach ($lines as $line) {
            [$l, $w, $h] = explode('x', trim($line));
            $l = (int) $l;
            $w = (int) $w;
            $h = (int) $h;
            $dimensions = [$l, $w, $h];
            sort($dimensions);
            $packagePaper = (2 * $l * $w) + (2 * $w * $h) + (2 * $h * $l);
            $slackPaper = $dimensions[0] * $dimensions[1];

            $totalPaper += $packagePaper + $slackPaper;
        }

        return (string) $totalPaper;
    }

    public function partTwo(): string
    {
        $lines = $this->readInputAsLines();

        $totalRibbon = 0;
        foreach ($lines as $line) {
            [$l, $w, $h] = explode('x', trim($line));
            $l = (int) $l;
            $w = (int) $w;
            $h = (int) $h;
            $dimensions = [$l, $w, $h];
            sort($dimensions);
            $packageRibbon = ($dimensions[0] * 2) + ($dimensions[1] * 2) + ($l * $w * $h);
            $totalRibbon += $packageRibbon;
        }

        return (string) $totalRibbon;
    }
}