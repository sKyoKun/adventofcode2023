<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day5Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day5', name: 'day5')]
class Day5Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day5Services $day5services
    ){
        $this->inputReader = $inputReader;
        $this->day5services = $day5services;
    }

    #[Route('/1/{file}', name: 'day5_1', defaults: ["file"=>"day5"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $seeds = $this->day5services->getSeeds($lines);

        $this->day5services->processMap($this->day5services->getSeedsToSoilMap($lines), $seeds);
        $this->day5services->processMap($this->day5services->getSoilToFertilizeMap($lines), $seeds);
        $this->day5services->processMap($this->day5services->getFertilizerToWaterMap($lines), $seeds);
        $this->day5services->processMap($this->day5services->getWaterToLightMap($lines), $seeds);
        $this->day5services->processMap($this->day5services->getLightToTemperatureMap($lines), $seeds);
        $this->day5services->processMap($this->day5services->getTemperatureToHumidityMap($lines), $seeds);
        $this->day5services->processMap($this->day5services->getHumidityToLocationMap($lines), $seeds);

        return new JsonResponse(min($seeds), Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day5_2', defaults: ["file"=>"day5"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
