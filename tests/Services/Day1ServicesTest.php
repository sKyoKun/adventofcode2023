<?php

namespace App\Tests\Services;

use App\Services\Day1Services;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day1ServicesTest extends TestCase
{
    #[DataProvider('retrieveCalibrationDataProvider')]
    public function testRetrieveCalibration(string $string, array $expectedResult): void
    {
        $day1Service = new Day1Services();
        self::assertSame($expectedResult, $day1Service->retrieveCalibration([$string]));
    }

    public static function retrieveCalibrationDataProvider(): \Generator
    {
        yield 'number case' => ['124', [14]];
        yield 'repeated number case 2' => ['4', [44]];
        yield 'Simple case' => ['eight124two9', [19]];
    }
    #[DataProvider('retrieveCalibrationWithLettersDataProvider')]
    public function testRetrieveCalibrationWithLetters(string $string, array $expectedResult): void
    {
        $day1Service = new Day1Services();
        self::assertSame($expectedResult, $day1Service->retrieveCalibrationWithLetters([$string]));
    }

    public static function retrieveCalibrationWithLettersDataProvider(): \Generator
    {
        yield 'number case' => ['124', [14]];
        yield 'repeated number case' => ['two', [22]];
        yield 'repeated number case 2' => ['4', [44]];
        yield 'Simple case' => ['eight124', [84]];
        yield 'Nested case' => ['eightwo12eighttwo', [82]];
    }
}
