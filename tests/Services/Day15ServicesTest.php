<?php
declare(strict_types=1);

namespace App\Tests\Services;

use App\Services\Day15Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class Day15ServicesTest extends TestCase
{
    #[DataProvider('testParseStringDataProvider')]
    public function test_parse_string(string $string, array $expected): void
    {
        $day15Service = new Day15Services();
        self::assertSame($expected, $day15Service->parseString($string));
    }

    public static function test_parse_string_data_provider(): \Generator
    {
        yield 'string with - ' => [
            'test-',
            ['test', '-', null],
        ];

        yield 'string with = ' => [
            'test=5',
            ['test', '=', '5'],
        ];
    }
}
