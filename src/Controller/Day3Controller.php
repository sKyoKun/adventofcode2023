<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day3Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day3', name: 'day3')]
class Day3Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day3Services $day3services
    ){
        $this->inputReader = $inputReader;
        $this->day3services = $day3services;
    }

    #[Route('/1/{file}', name: 'day3_1', defaults: ["file"=>"day3"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $parts = $this->day3services->retrievePartNumbers($lines);

        return new JsonResponse(array_sum($parts), Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day3_2', defaults: ["file"=>"day3"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
