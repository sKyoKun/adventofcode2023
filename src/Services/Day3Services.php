<?php
declare(strict_types=1);

namespace App\Services;

class Day3Services
{
    public const SYMBOL_CHARACTERS_REGEX = '`[^\d.]`';
    public const SYMBOL_STAR_REGEX = '#[*]#';

    public function retrievePartNumbers(array $lines): array
    {
        $partNumbers = [];
        foreach ($lines as $lineNumber => $line) {
            $matchesNumbers = [];
            preg_match_all('`\d+`', $line, $matchesNumbers, flags: PREG_OFFSET_CAPTURE);
            if ($matchesNumbers) {
                foreach ($matchesNumbers[0] as $matchesNumber) {
                    $number = $matchesNumber[0];
                    $positionStart = $matchesNumber[1];
                    if ($this->checkNumberIsPart($lines, [$lineNumber, $positionStart], strlen($number))) {
                        $partNumbers[] = $number;
                    }
                }
            }
        }

        return $partNumbers;
    }

    public function retrieveGearsValue(array $lines): int
    {
        $totalGears = 0;
        $starsArray = [];
        foreach ($lines as $lineNumber => $line) {
            $matchesNumbers = [];
            preg_match_all('`\d+`', $line, $matchesNumbers, flags: PREG_OFFSET_CAPTURE);
            if ($matchesNumbers) {
                foreach ($matchesNumbers[0] as $matchesNumber) {
                    $number = $matchesNumber[0];
                    $positionStart = $matchesNumber[1];
                    if ($this->checkNumberIsPart($lines, [$lineNumber, $positionStart], strlen($number))) {
                        $this->updateStarsArray($lines, [$lineNumber, $positionStart], $number, $starsArray);
                    }
                }
            }
        }
        foreach ($starsArray as $key => $star) {
            if (2 !== count($star)) {
                continue;
            }
            $totalGears += $star[0] * $star[1];
        }

        return $totalGears;
    }

    public function checkNumberIsPart(array $lines, array $startPos, int $length): bool
    {
        return $this->checkForSymbol($lines, $startPos, $length, self::SYMBOL_CHARACTERS_REGEX);
    }

    public function checkForSymbol(array $lines, array $startPos, int $length, string $symbol): bool
    {
        $maxY = strlen($lines[0]) - 1;
        // top line
        if ($startPos[0] > 0) {
            $lineToCheck = $startPos[0] - 1;
            for ($y = $startPos[1] - 1; $y <= $startPos[1] + $length; ++$y) {
                if ($y < 0 || $y > $maxY) {
                    continue;
                }
                if (preg_match($symbol, $lines[$lineToCheck][$y])) {
                    return true;
                }
            }
        }
        // bottom line
        if ($startPos[0] < count($lines) - 1) {
            for ($y = $startPos[1] - 1; $y <= $startPos[1] + $length; ++$y) {
                $lineToCheck = $startPos[0] + 1;
                if ($y < 0 || $y > $maxY) {
                    continue;
                }
                if (preg_match($symbol, $lines[$lineToCheck][$y])) {
                    return true;
                }
            }
        }

        $yToCheckBefore = $startPos[1] - 1;
        $yToCheckAfter = $startPos[1] + $length;
        if ($yToCheckBefore >= 0 && preg_match($symbol, $lines[$startPos[0]][$yToCheckBefore])) {
            return true;
        }

        if ($yToCheckAfter <= $maxY
            && preg_match($symbol, $lines[$startPos[0]][$yToCheckAfter])
        ) {
            return true;
        }

        return false;
    }

    public function updateStarsArray(array $lines, array $startPos, string $number, array &$starsArray): void
    {
        $maxY = strlen($lines[0]) - 1;
        // top line
        if ($startPos[0] > 0) {
            $lineToCheck = $startPos[0] - 1;
            for ($y = $startPos[1] - 1; $y <= $startPos[1] + strlen($number); ++$y) {
                if ($y < 0 || $y > $maxY) {
                    continue;
                }
                if (preg_match(self::SYMBOL_STAR_REGEX, $lines[$lineToCheck][$y])) {
                    $pos = $lineToCheck . '-' . $y;
                    $starsArray[$pos][] = (int) $number;
                }
            }
        }
        // bottom line
        if ($startPos[0] < count($lines) - 1) {
            for ($y = $startPos[1] - 1; $y <= $startPos[1] + strlen($number); ++$y) {
                $lineToCheck = $startPos[0] + 1;
                if ($y < 0 || $y > $maxY) {
                    continue;
                }
                if (preg_match(self::SYMBOL_STAR_REGEX, $lines[$lineToCheck][$y])) {
                    $pos = $lineToCheck . '-' . $y;
                    $starsArray[$pos][] = (int) $number;
                }
            }
        }

        $yToCheckBefore = $startPos[1] - 1;
        $yToCheckAfter = $startPos[1] + strlen($number);
        if ($yToCheckBefore >= 0 && preg_match(self::SYMBOL_STAR_REGEX, $lines[$startPos[0]][$yToCheckBefore])) {
            $pos = $startPos[0] . '-' . $yToCheckBefore;
            $starsArray[$pos][] = (int) $number;
        }

        if ($yToCheckAfter <= $maxY
            && preg_match(self::SYMBOL_STAR_REGEX, $lines[$startPos[0]][$yToCheckAfter])
        ) {
            $pos = $startPos[0] . '-' . $yToCheckAfter;
            $starsArray[$pos][] = (int) $number;
        }
    }
}
