<?php

namespace App\Tests\Services;

use App\Services\Day8Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

class Day8ServicesTest extends TestCase
{
    #[DataProvider('getMapDataProvider')]
    public function test_get_map(array $input, array $expectedOutput)
    {
        $day8Service = new Day8Services();

        self::assertSame($expectedOutput, $day8Service->getMaps($input));
    }

    public static function getMapDataProvider(): \Generator
    {
        yield 'test input' => [
            [
                '',
                'AAA = (BBB, BBB)',
                'BBB = (AAA, ZZZ)',
                'ZZZ = (ZZZ, ZZZ)',
            ],
            [
                'AAA' => ['BBB', 'BBB'],
                'BBB' => ['AAA', 'ZZZ'],
                'ZZZ' => ['ZZZ', 'ZZZ'],
            ],
        ];
    }

    public function test_get_steps_to_zzz()
    {
        $day8Service = new Day8Services();

        $instructions = 'LLR';
        $map = [
            'AAA' => ['BBB', 'BBB'],
            'BBB' => ['AAA', 'ZZZ'],
            'ZZZ' => ['ZZZ', 'ZZZ'],
        ];

        self::assertSame(6, $day8Service->getStepsToZZZ($instructions, $map));
    }
}
