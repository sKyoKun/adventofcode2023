<?php
declare(strict_types=1);

namespace App\Services;

class Day14Services
{
    public const EMPTY_SPACE = '.';
    public const ROCK = 'O';
    public const SQUARE = '#';

    public function moveRocks(array &$grid): void
    {
        foreach ($grid as &$line) {
            do {
                $lastPoint = null;
                $movedRocks = 0;
                for ($i = 0; $i < strlen($line); ++$i) {
                    if (self::EMPTY_SPACE === $line[$i]) {
                        $lastPoint = $i;
                    } elseif (self::ROCK === $line[$i]) {
                        $this->moveRock($lastPoint, $i, $line, $movedRocks);
                    }
                }
            } while ($movedRocks > 0);
        }
    }

    public function moveRock(?int &$pointPos, int $rockPos, string &$line, int &$movedRocks): void
    {
        if (null === $pointPos) {
            return;
        }

        $length = $rockPos - $pointPos;
        $subString = substr($line, $pointPos, $length);
        if (false === str_contains($subString, self::SQUARE)) {
            $line[$pointPos] = self::ROCK;
            $line[$rockPos] = self::EMPTY_SPACE;
            $pointPos = $rockPos;
            ++$movedRocks;
        }
    }

    public function calculateTotalLoad(array $grid): int
    {
        $totalLoad = 0;

        foreach ($grid as $line) {
            $reversedLine = strrev($line);
            for ($i = 0; $i < strlen($reversedLine); ++$i) {
                if (self::ROCK === $reversedLine[$i]) {
                    $totalLoad += $i + 1;
                }
            }
        }

        return $totalLoad;
    }
}
