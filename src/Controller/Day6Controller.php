<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day6Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day6', name: 'day6')]
class Day6Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day6Services $day6services
    ){
        $this->inputReader = $inputReader;
        $this->day6services = $day6services;
    }

    #[Route('/1/{file}', name: 'day6_1', defaults: ["file"=>"day6"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $races = $this->day6services->getRaces($lines);
        $waysToBeatRecords = [];
        foreach ($races as $time => $distance) {
            $waysToBeatRecords[] = $this->day6services->getWaysToBeatRecord((int) $time, (int) $distance);
        }

        return new JsonResponse(array_product($waysToBeatRecords), Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day6_2', defaults: ["file"=>"day6"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $race = $this->day6services->getRace($lines);
        $waysToBeatRecord = [];
        foreach ($race as $time => $distance) {
            $waysToBeatRecord[] = $this->day6services->getWaysToBeatRecord((int) $time, (int) $distance);
        }

        return new JsonResponse(array_product($waysToBeatRecord), Response::HTTP_OK);
    }
}
