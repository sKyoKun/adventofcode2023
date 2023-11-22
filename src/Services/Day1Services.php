<?php

namespace App\Services;

class Day1Services
{
    public function countCaloriesPerElves(array $input) : array
    {
        $elvesCalories = [];
        $elfNumber = 0;
        $totalCaloriesForElf = 0;

        foreach ($input as $value) {
            if (empty($value)) { // blank line = elve change
                $elvesCalories[$elfNumber] = $totalCaloriesForElf;
                $totalCaloriesForElf = 0;
                $elfNumber++;

                continue;
            }
            $totalCaloriesForElf += intval($value);
        }

        $elvesCalories[$elfNumber] = $totalCaloriesForElf; // there is no blank line after last line

        return $elvesCalories;
    }
}
