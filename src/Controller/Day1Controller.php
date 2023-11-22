<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day1Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day1', name: 'day1')]
class Day1Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day1Services $day1services;

    /**
     * @param InputReader $inputReader
     * @param Day1Services $day1services
     */
    public function __construct(InputReader $inputReader, Day1Services $day1services)
    {
        $this->inputReader = $inputReader;
        $this->day1services = $day1services;
    }

    #[Route('/1/{file}', name: 'day1_1', defaults: ["file"=>"day1"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $totalCaloriesPerElves = $this->day1services->countCaloriesPerElves($lines);

        return new JsonResponse(max($totalCaloriesPerElves), Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day1_2', defaults: ["file"=>"day1"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $totalCaloriesPerElves = $this->day1services->countCaloriesPerElves($lines);

        rsort($totalCaloriesPerElves);
        $top3mostCalories = $totalCaloriesPerElves[0] + $totalCaloriesPerElves[1] + $totalCaloriesPerElves[2];

        return new JsonResponse($top3mostCalories, Response::HTTP_OK);
    }
}
