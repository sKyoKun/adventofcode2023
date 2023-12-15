<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\Day15Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day15', name: 'day15')]
class Day15Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day15Services $day15services
    ) {}

    #[Route('/1/{file}', name: 'day15_1', defaults: ['file' => 'day15'])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');
        $strings = $this->day15services->getStringList($lines);
        $hashValueAfterInitialisingSequence = 0;
        foreach ($strings as $string) {
            $hashValueAfterInitialisingSequence += $this->day15services->calculateHashString($string);
        }

        return new JsonResponse($hashValueAfterInitialisingSequence, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day15_2', defaults: ['file' => 'day15'])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file . '.txt');
        $strings = $this->day15services->getStringList($lines);
        $boxes = [];
        foreach ($strings as $string) {
            $lens = $this->day15services->parseString($string);
            $this->day15services->putLensInBox($boxes, $lens);
        }

        $totalLensPower = 0;
        foreach ($boxes as $boxNumber => $box) {
            $totalLensPower += $this->day15services->calculateBoxFocusingPower($boxNumber + 1, $box);
        }

        return new JsonResponse($totalLensPower, Response::HTTP_OK);
    }
}
