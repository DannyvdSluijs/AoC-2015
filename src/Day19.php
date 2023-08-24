<?php

declare(strict_types=1);

namespace Dannyvdsluijs\AdventOfCode2015;

use Dannyvdsluijs\AdventOfCode2015\Concerns\ContentReader;

class Day19 implements PuzzleDay
{
    use ContentReader;

    public function partOne(): string
    {
        list($molecule, $replacements) = $this->parseInput();

        $molecules = [];
        $moleculeLength = strlen($molecule);
        $moleculeCharArray = str_split($molecule);

        for ($x = 0; $x < $moleculeLength; $x++) {
            $matchingReplacements = array_filter(
                $replacements,
                function ($replacement) use ($moleculeCharArray, $x, $moleculeLength) {
                    if ($replacement->identifierLength === 1) {
                        return $replacement->identifier === $moleculeCharArray[$x];
                    }
                    if ($replacement->identifierLength === 2 && $x + 1 < $moleculeLength) {
                        return $replacement->identifier === $moleculeCharArray[$x] . $moleculeCharArray[$x + 1];
                    }

                }
            );

            foreach ($matchingReplacements as $matchingReplacement) {
                $copy = $moleculeCharArray;
                $copy[$x] = $matchingReplacement->replacement;
                if ($matchingReplacement->identifierLength === 2) {
                    unset($copy[$x + 1]);
                }
                $new = implode($copy);

                $molecules[] = $new;
            }
        }

        $unique = array_unique($molecules);

        return (string) count($unique);
    }

    public function partTwo(): string
    {
        list($molecule, $replacements) = $this->parseInput();
        $totalReplacementCount = 0;

        usort($replacements, fn($left, $right) => $right->replacementLength <=> $left->replacementLength);

        while ($molecule !== 'e') {
            foreach ($replacements as $replacement) {
                while(str_contains($molecule, $replacement->replacement)) {
                    $count = 0;
                    $molecule = str_replace($replacement->replacement, $replacement->identifier, $molecule, $count);

                    if ($count > 0) {
                        $totalReplacementCount += $count;
                        break 2;
                    }
                }
            }
        }

        return (string) $totalReplacementCount;
    }

    /** @return array<int, string|array<int, \stdClass>> */
    public function parseInput(): array
    {
        $inputs = $this->readInputAsLines();

        $molecule = array_pop($inputs);
        array_pop($inputs);
        $replacements = array_map(
            function (string $replacement) {
                [$identifier, $replacement] = explode(' => ', $replacement);

                return (object)[
                    'identifier' => $identifier,
                    'identifierLength' => strlen($identifier),
                    'replacement' => $replacement,
                    'replacementLength' => strlen($replacement),
                ];
            },
            $inputs
        );
        return array($molecule, $replacements);
    }
}