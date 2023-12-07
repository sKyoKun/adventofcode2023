<?php
declare(strict_types=1);

namespace App\Services;

class Day5Services
{
    public function getSeeds(array $lines): array
    {
        $seedsNumbersMatches = [];
        preg_match_all('#\d+#', $lines[0], $seedsNumbersMatches);

        return $seedsNumbersMatches[0];
    }

    public function getSeedsToSoilMap(array $lines): array
    {
        return $this->getValuesForMap('seed-to-soil map:', $lines);
    }

    public function getSoilToFertilizeMap(array $lines): array
    {
        return $this->getValuesForMap('soil-to-fertilizer map:', $lines);
    }

    public function getFertilizerToWaterMap(array $lines): array
    {
        return $this->getValuesForMap('fertilizer-to-water map:', $lines);
    }

    public function getWaterToLightMap(array $lines): array
    {
        return $this->getValuesForMap('water-to-light map:', $lines);
    }

    public function getLightToTemperatureMap(array $lines): array
    {
        return $this->getValuesForMap('light-to-temperature map:', $lines);
    }

    public function getTemperatureToHumidityMap(array $lines): array
    {
        return $this->getValuesForMap('temperature-to-humidity map:', $lines);
    }

    public function getHumidityToLocationMap(array $lines): array
    {
        return $this->getValuesForMap('humidity-to-location map:', $lines);
    }

    public function processMap(array $map, array &$baseMap): void
    {
        foreach ($baseMap as &$seed) {
            foreach ($map as $line) {
                $destination = (int) $line[0];
                $source = (int) $line[1];
                $range = (int) $line[2];

                if ($source <= $seed && $seed <= ($source + $range)) {
                    $seed = $destination + ($seed - $source);

                    continue 2; // we found our seed, let's check the next one
                }
            }
        }
    }

    private function getValuesForMap(string $mapName, array $lines): array
    {
        $read = false;
        $seedsToSoilMap = [];
        foreach ($lines as $line) {
            if ($mapName === $line) {
                $read = true;

                continue;
            }

            if (true === $read) {
                if ('' === $line) { // we finished the numbers part
                    return $seedsToSoilMap;
                }

                $seedsToSoilMap[] = explode(' ', $line);
            }
        }

        return $seedsToSoilMap;
    }
}
