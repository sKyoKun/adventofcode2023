<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\Day7Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day7', name: 'day7')]
class Day7Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day7Services $day7services
    ) {
        $this->inputReader = $inputReader;
        $this->day7services = $day7services;
    }

    #[Route('/1/{file}', name: 'day7_1', defaults: ['file' => 'day7'])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        $handsAndBids = $this->day7services->parseHandAndBid($lines);
        $handsAndBids = $this->day7services->sortHands($handsAndBids);

        $totalWinnings = $this->day7services->calculateTotalWinning($handsAndBids);

        return new JsonResponse($totalWinnings, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day7_2', defaults: ['file' => 'day7'])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        $this->day7services->setUseJoker(true);

        $handsAndBids = $this->day7services->parseHandAndBid($lines);
        $handsAndBids = $this->day7services->sortHands($handsAndBids);

        $totalWinnings = $this->day7services->calculateTotalWinning($handsAndBids);

        return new JsonResponse($totalWinnings, Response::HTTP_OK);
    }
}
