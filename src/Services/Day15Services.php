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
}
