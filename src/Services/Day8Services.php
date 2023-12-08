<?php
declare(strict_types=1);

namespace App\Services;

class Day8Services
{
    public const INSTRUCTION_INDEXES = ['L' => 0, 'R' => 1];
    public const START = 'AAA';
    public const BASE_END_CONDITION = '#ZZZ#';
    public const Z_END_CONDITION = '#[A-Z0-9]{2}Z#'; // added number to fit tests samples

    public function getInstructions(array &$lines): string
    {
        $instructions = array_shift($lines);

        return $instructions;
    }

    public function getMaps(array $lines)
    {
        array_shift($lines); // remove blank line left after instructions
        $map = [];

        foreach ($lines as $line) { // AAA = (BBB, BBB)
            $explodedLine = explode(' = ', $line);
            $mapStart = $explodedLine[0];
            $mapDestinations = [];
            preg_match_all('#[A-Z]{3}#', $explodedLine[1], $mapDestinations);
            $map[$mapStart] = $mapDestinations[0];
        }

        return $map;
    }

    public function getStepsToDestination(string $instructions, array $map, string $start = self::START, string $end = self::BASE_END_CONDITION): int
    {
        $steps = 0;
        $currentInstructionNumber = 0;
        $currentStep = $start;
        while (true) {
            ++$steps;
            if ($currentInstructionNumber === strlen($instructions)) { // we're at the end of the instructions list
                $currentInstructionNumber = 0;
            }

            $currentInstruction = substr($instructions, $currentInstructionNumber, 1);

            $nextStep = $map[$currentStep][self::INSTRUCTION_INDEXES[$currentInstruction]];
            if (preg_match($end, $nextStep)) {
                return $steps;
            }
            $currentStep = $nextStep;
            ++$currentInstructionNumber;
        }
    }

    /*
     * To get the first time that the steps are at Z on the same time, we need to calculate for each "A" line how many steps it takes
     * Then we need to sort them and calculate the least common multiple as the patterns repeat
     */
    public function getSimultaneousZ(string $instructions, array $map)
    {
        $stepsToReachFirstZPerMapWithA = [];
        $mapsA = $this->filterAmaps($map);
        foreach ($mapsA as $step => $destinations) {
            $stepsToReachFirstZPerMapWithA[] = $this->getStepsToDestination($instructions, $map, $step, self::Z_END_CONDITION);
        }

        sort($stepsToReachFirstZPerMapWithA);
        $leastCommonMultiple = 0;
        $leastCommonMultiple = array_shift($stepsToReachFirstZPerMapWithA);

        foreach ($stepsToReachFirstZPerMapWithA as $nbSteps) {
            $leastCommonMultiple = $this->calculateLeastCommonMultiple($leastCommonMultiple, $nbSteps);
        }

        return $leastCommonMultiple;
    }

    public function filterAmaps(array $map): array
    {
        $mapsEndingWithA = [];
        foreach ($map as $step => $nextSteps) {
            if (preg_match('#[A-Z0-9]{2}A#', $step)) {
                $mapsEndingWithA[$step] = $nextSteps;
            }
        }

        return $mapsEndingWithA;
    }

    public function calculateLeastCommonMultiple(int $number1, int $number2)
    {
        return ($number1 * $number2) / $this->greatestCommonDivider($number1, $number2);
    }

    public function greatestCommonDivider(int $number1, int $number2)
    {
        if (0 === $number2) {
            return $number1;
        }

        return $this->greatestCommonDivider($number2, $number1 % $number2);
    }
}
