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
        $iterations = $this->getIterations($values);

        $nextValue = 0;
        foreach ($iterations as $iteration) {
            $nextValue += end($iteration);
        }

        return $nextValue;
    }

    public function calculatePreviousValueInHistory(array $values)
    {
        $iterations = $this->getIterations($values);
        $previousValue = array_pop($iterations)[0]; // get the last value

        for ($i = count($iterations) - 1; $i >= 0; --$i) {
            $previousValue = $iterations[$i][0] - $previousValue;
        }

        return $previousValue;
    }

    public function getIterations(array $history)
    {
        $iterationNumber = 0;
        $iterations[] = $history;
        while (1 !== count(array_unique($iterations[$iterationNumber]))) { // once we have the same value everywhere, stop
            for ($i = 0; $i < count($iterations[$iterationNumber]) - 1; ++$i) {
                $iterations[$iterationNumber + 1][] = $iterations[$iterationNumber][$i + 1] - $iterations[$iterationNumber][$i];
            }
            ++$iterationNumber;
        }

        return $iterations;
    }
}
