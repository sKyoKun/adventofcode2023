<?php

namespace App\Tests\Services;

use App\Services\Day5Services;
use App\Services\InputReader;
use PHPUnit\Framework\TestCase;

class Day5ServicesTest extends TestCase
{
    private array $lines;

    public function setUp() : void{
      parent::setUp();
        $inputReader = new InputReader('public/Files/');
        $this->lines = $inputReader->getInput('day5test.txt');
    }

    public function testGetSeeds()
    {
        $seedLine = 'seeds: 79 14 55 13';
        $day5service = new Day5Services();

        self::assertSame(['79', '14', '55', '13'], $day5service->getSeeds([$seedLine]));
    }

    public function testGetSeedsToSoilMap()
    {
        $day5service = new Day5Services();

        self::assertSame(
            [
                ['50', '98', '2'],
                ['52', '50', '48'],
            ],
            $day5service->getSeedsToSoilMap($this->lines)
        );
    }

    public function testGetSoilToFertilizeMap()
    {
        $day5service = new Day5Services();

        self::assertSame(
            [
                ['0','15', '37'],
                ['37', '52', '2'],
                ['39', '0', '15'],
            ],
            $day5service->getSoilToFertilizeMap($this->lines)
        );
    }
}
