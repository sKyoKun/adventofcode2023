<?php
declare(strict_types=1);

namespace App\Tests\Services;

use App\Services\Day9Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class Day9ServicesTest extends TestCase
{
    #[DataProvider('calculateNextValueInHistoryDataProvider')]
    public function test_calculate_next_value_in_history(array $input, int $expected): void
    {
        $day9service = new Day9Services();
        self::assertSame($expected, $day9service->calculateNextValueInHistory($input));
    }

    public static function calculateNextValueInHistoryDataProvider(): \Generator
    {
        yield 'history 1' => [
            [0, 3, 6, 9, 12, 15],
            18,
        ];

        yield 'history 2' => [
            [1, 3, 6, 10, 15, 21],
            28,
        ];

        yield 'history 3' => [
            [10, 13, 16, 21, 30, 45],
            68,
        ];
    }
}
