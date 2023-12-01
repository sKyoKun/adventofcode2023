<?php

namespace App\Services;

class Day1Services
{
    public const SEARCHED_VALUES = [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9,
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9
    ];

    public function retrieveCalibration(array $input) : array
    {
        $numbersPerLine = [];

        foreach ($input as $lineNumber => $line) {
            preg_match_all('#\d#', $line, $matches);
            if (1 < count($matches[0])) {
                $numbersPerLine[$lineNumber] = intval(array_shift($matches[0]).array_pop($matches[0]));
            } else {
                $doubleSameDigit = array_shift($matches[0]);
                $numbersPerLine[$lineNumber] = intval($doubleSameDigit.$doubleSameDigit);
            }
        }

        return $numbersPerLine;
    }

    public function retrieveCalibrationWithLetters(array $input) : array
    {
        $numbersPerLine = [];

        foreach ($input as $lineNumber => $line) {
            $currentWord = '';
            $firstNumber = null;
            $lastNumber = null;

            // We cant use regex as there is some nested words in the payload like eightwo (82)
            for($i=0; $i < strlen($line); $i++) {
                $currentWord .= $line[$i];
                $matches = null;
                preg_match('#\d|one|two|three|four|five|six|seven|eight|nine#', $currentWord, $matches);
                if($matches) {
                    $firstNumber = self::SEARCHED_VALUES[$matches[0]];
                }
            }

            $currentWord = '';
            for($j=(strlen($line)-1); $j >=0; $j--) {
                $currentWord = $line[$j].$currentWord;
                preg_match('#\d|one|two|three|four|five|six|seven|eight|nine#', $currentWord, $matches);
                if($matches) {
                    $lastNumber = self::SEARCHED_VALUES[$matches[0]];
                    break;
                }
            }

            $numbersPerLine[$lineNumber] = intval($firstNumber.$lastNumber);
        }

        return $numbersPerLine;
    }
}
