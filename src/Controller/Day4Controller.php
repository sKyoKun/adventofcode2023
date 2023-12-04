<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\Day4Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day4', name: 'day4')]
class Day4Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day4Services $day4services
    ) {
        $this->inputReader = $inputReader;
        $this->day4services = $day4services;
    }

    #[Route('/1/{file}', name: 'day4_1', defaults: ['file' => 'day4'])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        $games = $this->day4services->getCards($lines);
        $totalPoints = $this->day4services->calculatePoints($games);

        return new JsonResponse($totalPoints, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day4_2', defaults: ['file' => 'day4'])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        $games = $this->day4services->getCards($lines);
        $totalScratchboards = $this->day4services->calculateScratchboards($games);

        return new JsonResponse($totalScratchboards, Response::HTTP_OK);
    }
}
