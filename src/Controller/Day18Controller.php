<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\Day18Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day18', name: 'day18')]
class Day18Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day18Services $day18services
    ) {}

    #[Route('/1/{file}', name: 'day18_1', defaults: ['file' => 'day18'])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');
        $instructions = $this->day18services->parseInstructions($lines);

        $totalCubicMeters = $this->day18services->calculateCubicMeters($instructions);

        return new JsonResponse($totalCubicMeters, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day18_2', defaults: ['file' => 'day18'])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');
        $instructions = $this->day18services->parseInstructionWithHexValue($lines);
        $totalCubicMeters = $this->day18services->calculateCubicMeters($instructions);

        return new JsonResponse($totalCubicMeters, Response::HTTP_OK);
    }
}
