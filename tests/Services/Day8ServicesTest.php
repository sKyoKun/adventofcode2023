<?php
declare(strict_types=1);

namespace App\Tests\Services;

use App\Services\Day8Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class Day8ServicesTest extends TestCase
{
    #[DataProvider('getMapDataProvider')]
    public function test_get_map(array $input, array $expectedOutput): void
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

    public function test_get_steps_to_destination(): void
    {
        $day8Service = new Day8Services();

        $instructions = 'LLR';
        $map = [
            'AAA' => ['BBB', 'BBB'],
            'BBB' => ['AAA', 'ZZZ'],
            'ZZZ' => ['ZZZ', 'ZZZ'],
        ];

        self::assertSame(6, $day8Service->getStepsToDestination($instructions, $map));
    }

    public function test_filter_a_maps(): void
    {
        $day8Service = new Day8Services();

        $map = [
            'AAA' => ['BBB', 'BBB'],
            'BBB' => ['AAA', 'ZZZ'],
            'BBA' => ['AAZ', 'ZZZ'],
            'ZZZ' => ['ZZZ', 'ZZZ'],
        ];

        $output = [
            'AAA' => ['BBB', 'BBB'],
            'BBA' => ['AAZ', 'ZZZ'],
        ];

        self::assertSame($output, $day8Service->filterAmaps($map));
    }

    public function test_get_simultaneous_z(): void
    {
        $day8Service = new Day8Services();

        $instructions = 'LR';
        $map = [
            '11A' => ['11B', 'XXX'],
            '11B' => ['XXX', '11Z'],
            '11Z' => ['11B', 'XXX'],
            '22A' => ['22B', 'XXX'],
            '22B' => ['22C', '22C'],
            '22C' => ['22Z', '22Z'],
            '22Z' => ['22B', '22B'],
            'XXX' => ['XXX', 'XXX'],
        ];

        self::assertSame(6, $day8Service->getSimultaneousZ($instructions, $map));
    }
}
