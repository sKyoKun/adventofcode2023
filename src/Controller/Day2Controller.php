<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\Day2Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day2', name: 'day2')]
class Day2Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day2Services $day2services
    ) {
        $this->inputReader = $inputReader;
        $this->day2services = $day2services;
    }

    #[Route('/1/{file}', name: 'day2_1', defaults: ['file' => 'day2'])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        $setsOfCubes = $this->day2services->getSetsOfCubes($lines);
        $sumOfValidGames = $this->day2services->sumOfValidGames($setsOfCubes);

        return new JsonResponse($sumOfValidGames, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day2_2', defaults: ['file' => 'day2'])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
