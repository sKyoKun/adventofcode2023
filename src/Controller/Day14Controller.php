<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\Day14Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day14', name: 'day14')]
class Day14Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day14Services $day14services,
        private CalendarServices $calendarServices
    ) {}

    #[Route('/1/{file}', name: 'day14_1', defaults: ['file' => 'day14'])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');
        $reversedGrid = $this->calendarServices->getReversedGrid($lines);
        $this->day14services->moveRocks($reversedGrid);
        $totalLoad = $this->day14services->calculateTotalLoad($reversedGrid);

        return new JsonResponse($totalLoad, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day14_2', defaults: ['file' => 'day14'])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
