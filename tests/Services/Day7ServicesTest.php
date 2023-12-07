<?php
declare(strict_types=1);

namespace App\Tests\Services;

use App\Services\Day7Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class Day7ServicesTest extends TestCase
{
    #[DataProvider('determineHandTypeDataProvider')]
    public function test_determine_hand_type(string $input, string $expected): void
    {
        $day7service = new Day7Services();
        self::assertSame($expected, $day7service->determineHandType($input));
    }

    public static function determineHandTypeDataProvider(): \Generator
    {
        yield 'Five of a kind' => ['AAAAA', 'FiveKind'];
        yield 'Four of a kind' => ['AAAA1', 'FourKind'];
        yield 'Full house' => ['23332', 'FullHouse'];
        yield 'Three of a kind' => ['TTT98', 'ThreeKind'];
        yield 'Two pairs' => ['23432', 'TwoPairs'];
        yield 'One pair' => ['A23A4', 'OnePair'];
        yield 'High card' => ['23456', 'HighCard'];
    }

    #[DataProvider('compareHandDataProvider')]
    public function test_compare_hand(string $hand1, string $hand2, int $expected): void
    {
        $day7service = new Day7Services();
        self::assertSame($expected, $day7service->compareHand($hand1, $hand2));
    }

    public static function compareHandDataProvider(): \Generator
    {
        yield '1st hand rank < 2nd Hand rank' => ['AAAAA', 'A23A4', -1];
        yield '1st hand rank = 2nd Hand rank but first card better' => ['AAAAA', 'QQQQQ', -1];
        yield '1st hand rank = 2nd Hand rank but first card lower' => ['JJJJJ', 'QQQQQ', 1];
        yield '1st hand rank = 2nd Hand rank but third card better' => ['AAAAA', 'AAQAA', -1];
        yield '1st hand rank = 2nd Hand rank but fouth card lower' => ['AAAJA', 'AAAAA', 1];
        yield '1st hand rank > 2nd Hand rank' => ['A23A4', 'AAAAA', 1];
    }

    public function test_order_hand(): void
    {
        $day7service = new Day7Services();
        $input = ['A23A4' => 123, 'JJJJJ' => 456, 'AAAAA' => 728, 'AAQAA' => 628, 'JQJQJ' => 922, 'JJJ89' => 536, 'AJJA7' => 562];
        $output = ['AAAAA' => 728, 'JJJJJ' => 456, 'AAQAA' => 628, 'JQJQJ' => 922, 'JJJ89' => 536, 'AJJA7' => 562, 'A23A4' => 123];

        self::assertSame($output, $day7service->sortHands($input));
    }
}
