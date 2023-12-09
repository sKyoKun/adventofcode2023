<?php
declare(strict_types=1);

namespace App\Services;

class Day9Services
{
    public function parseHistories(array $lines)
    {
        $histories = [];
        foreach ($lines as $line) {
            $histories[] = explode(' ', $line);
        }

        return $histories;
    }

    public function calculateNextValueInHistory(array $values)
    {
        $iterationNumber = 0;
        $iterations[] = $values;
        while (1 !== count(array_unique($iterations[$iterationNumber]))) { // once we have the same value everywhere, stop
            for ($i = 0; $i < count($iterations[$iterationNumber]) - 1; ++$i) {
                $iterations[$iterationNumber + 1][] = $iterations[$iterationNumber][$i + 1] - $iterations[$iterationNumber][$i];
            }
            ++$iterationNumber;
        }

        $nextValue = 0;
        foreach ($iterations as $iteration) {
            $nextValue += end($iteration);
        }

        return $nextValue;
    }
}
