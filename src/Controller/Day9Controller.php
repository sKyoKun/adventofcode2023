<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\Day9Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day9', name: 'day9')]
class Day9Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day9Services $day9services
    ) {
        $this->inputReader = $inputReader;
        $this->day9services = $day9services;
    }

    #[Route('/1/{file}', name: 'day9_1', defaults: ['file' => 'day9'])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        $sumOfExtrapolatedValues = 0;
        $histories = $this->day9services->parseHistories($lines);
        foreach ($histories as $history) {
            $sumOfExtrapolatedValues += $this->day9services->calculateNextValueInHistory($history);
        }

        return new JsonResponse($sumOfExtrapolatedValues, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day9_2', defaults: ['file' => 'day9'])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        $sumOfExtrapolatedValues = 0;
        $histories = $this->day9services->parseHistories($lines);
        foreach ($histories as $history) {
            $sumOfExtrapolatedValues += $this->day9services->calculatePreviousValueInHistory($history);
        }

        return new JsonResponse($sumOfExtrapolatedValues, Response::HTTP_OK);
    }
}
