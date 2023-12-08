<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\Day8Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day8', name: 'day8')]
class Day8Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day8Services $day8services
    ) {
        $this->inputReader = $inputReader;
        $this->day8services = $day8services;
    }

    #[Route('/1/{file}', name: 'day8_1', defaults: ['file' => 'day8'])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');
        $instructions = $this->day8services->getInstructions($lines);
        $map = $this->day8services->getMaps($lines);
        $steps = $this->day8services->getStepsToDestination($instructions, $map);

        return new JsonResponse($steps, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day8_2', defaults: ['file' => 'day8'])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        $instructions = $this->day8services->getInstructions($lines);
        $map = $this->day8services->getMaps($lines);
        $steps = $this->day8services->getSimultaneousZ($instructions, $map);

        return new JsonResponse($steps, Response::HTTP_OK);
    }
}
