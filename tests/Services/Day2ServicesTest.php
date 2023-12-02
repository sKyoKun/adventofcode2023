<?php
declare(strict_types=1);

namespace App\Tests\Services;

use App\Services\Day2Services;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

/**
 * @internal
 */
final class Day2ServicesTest extends TestCase
{
    public function test_get_sets_of_cubes(): void
    {
        $day2Service = new Day2Services();
        $games = $day2Service->getSetsOfCubes([
            'Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green',
            'Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue',
            'Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red',
            'Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red',
            'Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green',
        ]);
        assertSame(
            [
                1 => ['red' => [4, 1], 'blue' => [3, 6], 'green' => [2, 2]],
                2 => ['green' => [2, 3, 1], 'blue' => [1, 4, 1], 'red' => [1]],
                3 => ['green' => [8, 13, 5], 'red' => [20, 4, 1], 'blue' => [6, 5]],
                4 => ['green' => [1, 3, 3], 'red' => [3, 6, 14], 'blue' => [6, 15]],
                5 => ['green' => [3, 2], 'red' => [6, 1], 'blue' => [1, 2]],
            ],
            $games
        );
    }

    public function test_sum_of_valid_games(): void
    {
        $day2Service = new Day2Services();
        $sum = $day2Service->sumOfValidGames(
            [
                1 => ['green' => [2, 2], 'red' => [4, 1], 'blue' => [3, 6]],
                2 => ['green' => [2, 3, 1], 'red' => [1], 'blue' => [1, 4, 1]],
                3 => ['green' => [8, 13, 5], 'red' => [20, 4, 1], 'blue' => [6, 5]],
                4 => ['green' => [1, 3, 3], 'red' => [3, 6, 14], 'blue' => [6, 15]],
                5 => ['green' => [3, 2], 'red' => [6, 1], 'blue' => [1, 2]],
            ],
        );
        self::assertSame(8, $sum);
    }
}
