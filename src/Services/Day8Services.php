<?php

namespace App\Services;

class Day8Services
{
    public const INSTRUCTION_INDEXES = ['L' => 0, 'R' => 1];
    public const START = 'AAA';
    public const END = 'ZZZ';

    public function getInstructions(array &$lines): string
    {
        $instructions = array_shift($lines);

        return $instructions;
    }

    public function getMaps(array $lines)
    {
        array_shift($lines); // remove blank line left after instructions
        $map = [];

        foreach ($lines as $line) { //AAA = (BBB, BBB)
            $explodedLine = explode(' = ', $line);
            $mapStart = $explodedLine[0];
            $mapDestinations = [];
            preg_match_all('#[A-Z]{3}#', $explodedLine[1], $mapDestinations);
            $map[$mapStart] = $mapDestinations[0];
        }

        return $map;
    }

    public function getStepsToZZZ(string $instructions, array $map) : int
    {
        $steps = 0;
        $currentInstructionNumber = 0;
        $currentStep = self::START;
        while(true) {
            $steps++;
            if ($currentInstructionNumber === strlen($instructions)) { // we're at the end of the instructions list
                $currentInstructionNumber = 0;
            }

            $currentInstruction = substr($instructions, $currentInstructionNumber, 1);

            $nextStep = $map[$currentStep][self::INSTRUCTION_INDEXES[$currentInstruction]];
            if ($nextStep === self::END) {
                return $steps;
            }
            $currentStep = $nextStep;
            $currentInstructionNumber++;
        }
    }
}
