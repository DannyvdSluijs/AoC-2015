<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

class Day02
{
    public function partOne(): string
    {
        $content = file_get_contents(__DIR__ . '/../inputs/day2.txt');
        $lines = explode("\n", $content);

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
        $content = file_get_contents(__DIR__ . '/../inputs/day2.txt');
        $lines = explode("\n", $content);

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