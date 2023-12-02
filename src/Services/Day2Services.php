<?php
declare(strict_types=1);

namespace App\Services;

class Day2Services
{
    public const MAX_CUBES = [
        'red' => 12,
        'green' => 13,
        'blue' => 14,
    ];

    public function sumOfValidGames(array $games): int
    {
        $sum = 0;
        foreach ($games as $gameNumber => $game) {
            $maxGreen = max($game['green']);
            $maxRed = max($game['red']);
            $maxBlue = max($game['blue']);

            if ($maxGreen <= self::MAX_CUBES['green'] && $maxRed <= self::MAX_CUBES['red'] && $maxBlue <= self::MAX_CUBES['blue']) {
                $sum += $gameNumber;
            }
        }

        return $sum;
    }

    public function calculatePower(array $games): int
    {
        $sum = 0;
        foreach ($games as $game) {
            $maxGreen = max($game['green']);
            $maxRed = max($game['red']);
            $maxBlue = max($game['blue']);

            $gamePower = $maxBlue * $maxRed * $maxGreen;
            $sum += $gamePower;
        }

        return $sum;
    }

    public function getSetsOfCubes(array $lines): array
    {
        $setsPerGame = [];
        foreach ($lines as $line) {
            $gameNumber = null;
            $matches = null;
            preg_match('#Game (\d+):#', $line, $matches);
            if ($matches) {
                $gameNumber = $matches[1];

                $sets = explode(';', $line);
                foreach ($sets as $set) {
                    $matchGreen = [];
                    $matchRed = [];
                    $matchBlue = [];
                    preg_match('#(\d+) green#', $set, $matchGreen);
                    if ($matchGreen) {
                        array_shift($matchGreen); // remove the whole string
                        $setsPerGame[$gameNumber]['green'][] = (int) $matchGreen[0];
                    }

                    preg_match('#(\d+) red#', $set, $matchRed);
                    if ($matchRed) {
                        array_shift($matchRed); // remove the whole string
                        $setsPerGame[$gameNumber]['red'][] = (int) $matchRed[0];
                    }

                    preg_match('#(\d+) blue#', $set, $matchBlue);
                    if ($matchBlue) {
                        array_shift($matchBlue); // remove the whole string
                        $setsPerGame[$gameNumber]['blue'][] = (int) $matchBlue[0];
                    }
                }
            }
        }

        return $setsPerGame;
    }
}
