<?php
declare(strict_types=1);

namespace App\Services;

class Day18Services
{
    public function parseInstructions(array $lines)
    {
        $instructions = [];
        foreach ($lines as $line) {
            $explodedLine = explode(' ', $line);
            $direction = $explodedLine[0];
            $numberSteps = $explodedLine[1];
            $color = trim($explodedLine[2], '()');
            $instructions[] = ['direction' => $direction, 'steps' => $numberSteps, 'color' => $color];
        }

        return $instructions;
    }

    public function calculateCubicMeters(array $instructions)
    {
        $area = 0;
        $currentPos = [0, 0];
        $totalSteps = 0;

        foreach ($instructions as $instruction) {
            $totalSteps += $instruction['steps'];
            $newPoint = match ($instruction['direction']) {
                'R' => [$currentPos[0] + $instruction['steps'], $currentPos[1]],
                'D' => [$currentPos[0], $currentPos[1] + $instruction['steps']],
                'L' => [$currentPos[0] - $instruction['steps'], $currentPos[1]],
                'U' => [$currentPos[0], $currentPos[1] - $instruction['steps']],
            };
            // shoelace formula see https://www.101computing.net/the-shoelace-algorithm/
            $area += $currentPos[0] * $newPoint[1] - $newPoint[0] * $currentPos[1];
            $currentPos = $newPoint;
        }
        $content = abs($area) / 2;
        // pick's theorem https://en.wikipedia.org/wiki/Pick%27s_theorem
        $border = $totalSteps / 2;

        return $content + $border + 1;
    }

    public function parseInstructionWithHexValue(array $lines)
    {
        $directionList = ['0' => 'R', '1' => 'D', '2' => 'L', '3' => 'U'];

        $instructions = [];
        foreach ($lines as $line) {
            $explodedLine = explode(' ', $line);
            $hexValue = trim($explodedLine[2], '()');
            $direction = $directionList[substr($hexValue, -1)];
            $numberSteps = hexdec(substr($hexValue, 1, 5));
            $instructions[] = ['direction' => $direction, 'steps' => $numberSteps, 'color' => null];
        }

        return $instructions;
    }
}
