<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day11Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day11', name: 'day11')]
class Day11Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day11Services $day11services,
        private CalendarServices $calendarServices
    ){
    }

    #[Route('/1/{file}', name: 'day11_1', defaults: ["file"=>"day11"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $initialGrid = $this->calendarServices->parseInputFromStringsToArray($lines);
        $expandedGrid = $this->day11services->expandGrid($initialGrid);
        $hashPositions = $this->day11services->getHashPositions($expandedGrid);

        $totalLength = 0;
        foreach ($hashPositions as $number => $hashPosition) {
            for($i = $number+1; $i < count($hashPositions); $i++) {
                $totalLength += $this->day11services->calculateLength($hashPosition, $hashPositions[$i]);
            }
        }

        return new JsonResponse($totalLength, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day11_2', defaults: ["file"=>"day11"])]
    public function part2(string $file): JsonResponse
    {
        $expandValue = 100;

        $lines = $this->inputReader->getInput($file.'.txt');
        $initialGrid = $this->calendarServices->parseInputFromStringsToArray($lines);
        $emptyColumns = $this->day11services->findEmptyColumns($initialGrid);
        $emptyLines = $this->day11services->findEmptyLines($initialGrid);
        $hashPositions = $this->day11services->getHashPositions($initialGrid);

        $totalLength = 0;
        foreach ($hashPositions as $number => $hashPosition) {
            for($i = $number+1; $i < count($hashPositions); $i++) {
                $totalLength += $this->day11services->calculateLengthWithExpansion($hashPosition, $hashPositions[$i], $emptyLines, $emptyColumns, $expandValue);
            }
        }

        return new JsonResponse($totalLength, Response::HTTP_OK);
    }
}
