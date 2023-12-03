<?php

namespace App\Services;

class Day3Services
{
    public const SYMBOL_CHARACTERS_REGEX = '`[^\d.]`';
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

        public function checkNumberIsPart(array $lines, array $startPos, int $length): bool
        {
            $maxY = strlen($lines[0]) -1;
            // top line
            if ($startPos[0] > 0) {
                $lineToCheck = $startPos[0] -1;
                for($y = $startPos[1] - 1; $y <= $startPos[1] + $length; $y++) {
                    if ($y < 0 || $y > $maxY) {
                        continue;
                    }
                    if (preg_match(self::SYMBOL_CHARACTERS_REGEX, $lines[$lineToCheck][$y])) {
                        return true;
                    }
                }
            }
            // bottom line
            if ($startPos[0] < count($lines)-1) {
                for($y = $startPos[1] - 1; $y <= $startPos[1] + $length; $y++) {
                    $lineToCheck = $startPos[0] +1;
                    if ($y < 0 || $y > $maxY) {
                        continue;
                    }
                    if (preg_match(self::SYMBOL_CHARACTERS_REGEX, $lines[$lineToCheck][$y])) {
                        return true;
                    }
                }
            }

            $yToCheckBefore = $startPos[1] -1;
            $yToCheckAfter = $startPos[1]+$length;
            if ($yToCheckBefore >= 0 && preg_match(self::SYMBOL_CHARACTERS_REGEX, $lines[$startPos[0]][$yToCheckBefore])) {
                return true;
            }

            if ($yToCheckAfter <= $maxY
                && preg_match(self::SYMBOL_CHARACTERS_REGEX, $lines[$startPos[0]][$yToCheckAfter])
            ) {
                return true;
            }

            return false;
        }
}
