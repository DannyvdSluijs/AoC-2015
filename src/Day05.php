<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day05
{
    use ContentReader;

    public function partOne(): string
    {
        $content = $this->readInputForDay(5);
        $lines = explode("\n", $content);
        $nice = 0;
        $vowels = ['a', 'e', 'i', 'o', 'u'];

        foreach ($lines as $line) {
            if (
                str_contains($line, 'ab')
                || str_contains($line, 'cd')
                || str_contains($line, 'pq')
                || str_contains($line, 'xy')
            ) {
                continue;
            }

            $characters = str_split($line);
            $characterCount = array_count_values($characters);

            $containsOneLetterTwiceInARow = false;
            foreach(range('a', 'z') as $character) {
                if (str_contains($line, $character . $character)) {
                    $containsOneLetterTwiceInARow = true;
                }
            }

            if (!$containsOneLetterTwiceInARow) {
                continue;
            }


            $vowelCount = 0;
            foreach ($vowels as $vowel) {
               if (!array_key_exists($vowel, $characterCount)) {
                   continue;
               }

               $vowelCount += $characterCount[$vowel];
            }

            if ($vowelCount < 3) {
                continue;
            }

            $nice++;
        }

        return (string) $nice;
    }

    public function partTwo(): string
    {
        $content = $this->readInputForDay(5);
        $lines = explode("\n", $content);
        $nice = 0;

        foreach ($lines as $line) {
            $meetsCriteriaOne = false;
            $meetsCriteriaTwo = false;
            foreach(range('a', 'z') as $characterOne) {
                foreach(range('a', 'z') as $characterTwo) {
                    if (substr_count($line, $characterOne . $characterTwo) == 2) {
                        $meetsCriteriaOne = true;
                    }

                    if (substr_count($line, $characterOne . $characterTwo . $characterOne) == 1) {
                        $meetsCriteriaTwo = true;
                    }

                    if ($meetsCriteriaOne && $meetsCriteriaTwo) {
                        $nice++;
                        continue 3;
                    }
                }
            }
        }

        return (string) $nice;
    }
}