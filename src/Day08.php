<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day08
{
    use ContentReader;

    public function partOne(): string
    {
        $lines = $this->readInputAsLines();
        $charactersOfCodeCount = 0;
        $charactersOfStringCount = 0;

        $replacements = [];
        for ($x = 0x00; $x <= 0xff; $x++) {
            $key = '\x' . sprintf('%02s', dechex($x));
            $value = chr($x);
            $replacements[$key] = $value;
        }
        $search = array_keys($replacements);
        $replace = array_values($replacements);

        foreach ($lines as $line) {
            $charactersOfCodeCount += strlen($line);

            $line = substr($line, 1, -1);
            $line = str_replace($search, $replace , $line);
            $line = stripslashes($line);

            $charactersOfStringCount += strlen($line);
        }

        return (string) ($charactersOfCodeCount - $charactersOfStringCount);
    }

    public function partTwo(): string
    {
        $lines = $this->readInputAsLines();
        $originalLength = 0;
        $newLength = 0;

        $replacements = [];
        $replacements['\\'] = '\\\\';
        $replacements['"'] = '\"';
        $search = array_keys($replacements);
        $replace = array_values($replacements);

        foreach ($lines as $line) {
            $originalLength += strlen($line);

            $line = str_replace($search, $replace, $line);
            $line = '"' . $line . '"';

            $newLength += strlen($line);
        }

        return (string) ($newLength - $originalLength);
    }

}