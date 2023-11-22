<?php


namespace App\Services;

class CalendarServices
{
    public function parseInputWithIntegersAndComma(array $lines)
    {
        $finalArray = [];
        foreach ($lines as $key => $line) {
            $arrLine = explode(',', $line);
            foreach ($arrLine as $keyLine => $number) {
                $arrLine[$keyLine] = (int)$number;
            }
            $finalArray[$key] = $arrLine;
        }

        return $finalArray;
    }

    // a bc turns to ['a',' ','b','c']
    public function parseInputFromStringsToArray(array $lines)
    {
        $finalArray = [];

        foreach ($lines as $key => $line) {
            $arrLine = str_split($line);
            $finalArray[$key] = $arrLine;
        }

        return $finalArray;
    }

    // a bc turns to ['a', 'bc']
    public function parseInputFromStringsWithSpaceToArray(array $lines)
    {
        $finalArray = [];

        foreach ($lines as $key => $line) {
            $arrLine = explode(' ',$line);
            $finalArray[$key] = $arrLine;
        }

        return $finalArray;
    }

    public function parseInputFromStringsToIntArray(array $lines)
    {
        $finalArray = [];

        foreach ($lines as $key => $line) {
            $arrLine = array_map('intval', str_split($line));
            $finalArray[$key] = $arrLine;
        }

        return $finalArray;
    }
}
