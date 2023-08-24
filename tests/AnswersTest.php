<?php

declare(strict_types=1);

use Dannyvdsluijs\AdventOfCode2015\PuzzleDay;
use PHPUnit\Framework\TestCase;

class AnswersTest extends TestCase
{
    /**
     * @dataProvider answersDataProvider
     */
    public function testAnswerIsCorrect(string $dayClassName, string $answerPartOne, string $answerPartTwo): void
    {
        /** @var PuzzleDay $day */
        $day = new $dayClassName();

        self::assertSame($answerPartOne, $day->partOne());
        self::assertSame($answerPartTwo, $day->partTwo());

    }

    public static  function answersDataProvider(): array
    {
        return [
            'Day 1' => [\Dannyvdsluijs\AdventOfCode2015\Day01::class, '138', '1771'],
            'Day 2' => [\Dannyvdsluijs\AdventOfCode2015\Day02::class, '1598415', '3812909'],
            'Day 3' => [\Dannyvdsluijs\AdventOfCode2015\Day03::class, '2081', '2341'],
            'Day 4' => [\Dannyvdsluijs\AdventOfCode2015\Day04::class, '282749', '9962624'],
            'Day 5' => [\Dannyvdsluijs\AdventOfCode2015\Day05::class, '238', '69'],
            'Day 6' => [\Dannyvdsluijs\AdventOfCode2015\Day06::class, '377891', '14110788'],
            'Day 7' => [\Dannyvdsluijs\AdventOfCode2015\Day07::class, '3176', '14710'],
            'Day 8' => [\Dannyvdsluijs\AdventOfCode2015\Day08::class, '1371', '2117'],
            'Day 9' => [\Dannyvdsluijs\AdventOfCode2015\Day09::class, '251', '898'],
            'Day 10' => [\Dannyvdsluijs\AdventOfCode2015\Day10::class, '360154', '5103798'],
            'Day 11' => [\Dannyvdsluijs\AdventOfCode2015\Day11::class, 'hxbxxyzz', 'hxcaabcc'],
            'Day 12' => [\Dannyvdsluijs\AdventOfCode2015\Day12::class, '119433', '68466'],
            'Day 13' => [\Dannyvdsluijs\AdventOfCode2015\Day13::class, '709', '668'],
            'Day 14' => [\Dannyvdsluijs\AdventOfCode2015\Day14::class, '2660', '1256'],
            'Day 15' => [\Dannyvdsluijs\AdventOfCode2015\Day15::class, '21367368', '1766400'],
            'Day 16' => [\Dannyvdsluijs\AdventOfCode2015\Day16::class, '213', '323'],
            'Day 17' => [\Dannyvdsluijs\AdventOfCode2015\Day17::class, '1304', '18'],
            'Day 18' => [\Dannyvdsluijs\AdventOfCode2015\Day18::class, '821', '886'],
            'Day 19' => [\Dannyvdsluijs\AdventOfCode2015\Day19::class, '518', '200'],
            'Day 20' => [\Dannyvdsluijs\AdventOfCode2015\Day20::class, '786240', '831600'],
            'Day 21' => [\Dannyvdsluijs\AdventOfCode2015\Day21::class, '78', '148'],
            'Day 22' => [\Dannyvdsluijs\AdventOfCode2015\Day22::class, '1824', '1937'],
            'Day 23' => [\Dannyvdsluijs\AdventOfCode2015\Day23::class, '307', '160'],
            'Day 24' => [\Dannyvdsluijs\AdventOfCode2015\Day24::class, '11846773891', '80393059'],
            'Day 25' => [\Dannyvdsluijs\AdventOfCode2015\Day25::class, '9132360', ''],
        ];
    }

}