<?php
declare(strict_types=1);

namespace App\Tests\Services;

use App\Services\Day4Services;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

/**
 * @internal
 */
final class Day4ServicesTest extends TestCase
{
    public const INPUT =  [
        'Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53',
        'Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19',
        'Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1',
        'Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83',
        'Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36',
        'Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11',
    ];
    public function testGetCards()
    {
        $day4Service = new Day4Services();

        self::assertSame(
            [
                1 => ['winning' => ['41', '48', '83', '86', '17'], 'mycards' => ['83', '86', '6', '31', '17', '9', '48', '53']],
                2 => ['winning' => ['13', '32', '20', '16', '61'], 'mycards' => ['61', '30', '68', '82', '17', '32', '24', '19']],
                3 => ['winning' => ['1', '21', '53', '59', '44'], 'mycards' => ['69', '82', '63', '72', '16', '21', '14', '1']],
                4 => ['winning' => ['41', '92', '73', '84', '69'], 'mycards' => ['59', '84', '76', '51', '58', '5', '54', '83']],
                5 => ['winning' => ['87', '83', '26', '28', '32'], 'mycards' => ['88', '30', '70', '12', '93', '22', '82', '36']],
                6 => ['winning' => ['31', '18', '13', '56', '72'], 'mycards' => ['74', '77', '10', '23', '35', '67', '36', '11']],
            ],
            $day4Service->getCards(self::INPUT)
        );
    }

    public function testCalculatePoints()
    {
        $day4Service = new Day4Services();
        $games = $day4Service->getCards(self::INPUT);

        self::assertSame(13, $day4Service->calculatePoints($games));
    }

    public function testCalculateScratchboards()
    {
        $day4Service = new Day4Services();
        $games = $day4Service->getCards(self::INPUT);

        self::assertSame(30, $day4Service->calculateScratchboards($games));
    }
}
