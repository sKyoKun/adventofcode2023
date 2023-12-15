<?php
declare(strict_types=1);

namespace App\Services;

class Day15Services
{
    public function getStringList(array $lines)
    {
        return explode(',', $lines[0]);
    }

    public function calculateHashString(string $string): int
    {
        $currentHashValue = 0;

        for ($i = 0; $i < strlen($string); ++$i) {
            $currentHashValue += ord($string[$i]);
            $currentHashValue *= 17;
            $currentHashValue %= 256;
        }

        return $currentHashValue;
    }

    public function parseString(string $string): array
    {
        $number = null;
        $isEqualSignPresent = str_contains($string, '=');
        if ($isEqualSignPresent) {
            $explodedString = explode('=', $string);
            $label = $explodedString[0];
            $operand = '=';
            $number = $explodedString[1];
        } else {
            $explodedString = explode('-', $string);
            $label = $explodedString[0];
            $operand = '-';
        }

        return [$label, $operand, $number];
    }

    public function putLensInBox(array &$boxes, array $lens): void
    {
        // boxes[] = [label => number]
        $label = $lens[0];
        $operand = $lens[1];
        $number = $lens[2];
        $boxNumber = $this->calculateHashString($label);

        if ('=' === $operand) {
            $boxes[$boxNumber][$label] = $number;
        } else {
            unset($boxes[$boxNumber][$label]);
        }
    }

    public function calculateBoxFocusingPower(int $boxNumber, array $box): int
    {
        $totalPower = 0;
        $slotNumber = 1;
        foreach ($box as $value) {
            $totalPower += $boxNumber * $slotNumber * $value;
            ++$slotNumber;
        }

        return $totalPower;
    }
}
