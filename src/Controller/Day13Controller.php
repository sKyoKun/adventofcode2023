<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\Day13Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day13', name: 'day13')]
class Day13Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day13Services $day13services
    ) {
        $this->inputReader = $inputReader;
        $this->day13services = $day13services;
    }

    #[Route('/1/{file}', name: 'day13_1', defaults: ['file' => 'day13'])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');
        $grids = $this->day13services->getGrids($lines);
        $total = 0;
        foreach ($grids as $grid) {
            $verticalPattern = $this->day13services->getVerticalStrings($grid);
            if (null !== $this->day13services->getSymmetryStart($verticalPattern)) { // check vertical symmetry first (some pattern have both but only vertical should count)
                $total += ($this->day13services->getSymmetryStart($verticalPattern) + 1);
            } else {
                $total += ($this->day13services->getSymmetryStart($grid) + 1) * 100;
            }
        }

        return new JsonResponse($total, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day13_2', defaults: ['file' => 'day13'])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');

        $grids = $this->day13services->getGrids($lines);
        $total = 0;
        foreach ($grids as $grid) {
            $verticalPattern = $this->day13services->getVerticalStrings($grid);
            $verticalSymmetry = $this->day13services->getSymmetryStart($verticalPattern, true);
            $horizontalSymmetry = $this->day13services->getSymmetryStart($grid, true);
            if (null !== $verticalSymmetry) { // check vertical symmetry first (some pattern have both but only vertical should count)
                $total += $verticalSymmetry + 1;
            } else {
                $total += ($horizontalSymmetry + 1) * 100;
            }
        }

        return new JsonResponse($total, Response::HTTP_OK);
    }
}
