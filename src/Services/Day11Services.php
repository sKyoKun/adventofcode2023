<?php

namespace App\Services;

class Day11Services
{
    public function expandGrid(array $grid): array
    {
        // expand vertically
        $newGrid = $this->expandVertically($grid);

        // expand horizontally
        $emptyColumns = $this->findEmptyColumns($newGrid);
        $newGrid = $this->expandHorizontally($newGrid, $emptyColumns);

        return $newGrid;
    }

    public function expandVertically(array $grid): array
    {
        foreach ($grid as $line) {
            if (false === array_search('#', $line)) {
                $newGrid[] = $line;
            }
            $newGrid[] = $line;
        }

        return $newGrid;
    }

    public function expandHorizontally(array $grid, array $emptyColumns): array
    {
        foreach ($grid as &$line) {
            $colToAdd = 0; // For each '.' we add, we also add a column, so oldColumn key should be updated
            foreach ($emptyColumns as $emptyColumn) {
                array_splice($line, $emptyColumn+$colToAdd, 0, '.');
                $colToAdd++;
            }
        }

        return $grid;
    }

    public function findEmptyColumns(array $grid): array
    {
        $columns = range(0, count($grid[0]) - 1);
        foreach ($grid as $line) {
            foreach ($line as $columnKey => $columnValue) {
                if (false === array_search($columnKey, $columns) || '.' === $columnValue) {
                    continue;
                }
                // if it's an # then we remove the column from the array to be duplicated
                $toRemove = array_search($columnKey, $columns);
                unset($columns[$toRemove]);
            }
        }

        return $columns;
    }

    public function findEmptyLines(array $grid): array
    {
        $emptyLines = [];
        foreach ($grid as $lineNumber => $line) {
            if (false === array_search('#', $line)) {
                $emptyLines[] = $lineNumber;
            }
        }

        return $emptyLines;
    }

    public function getHashPositions(array $grid): array
    {
        $hashPositions = [];
        foreach ($grid as $lineNumber => $line) {
            foreach ($line as $colNumber => $value) {
                if ('#' === $value) {
                    $hashPositions[] = [$lineNumber, $colNumber];
                }
            }
        }

        return $hashPositions;
    }

    public function calculateLength(array $pointA, array $pointB): int
    {
        return abs($pointB[0]-$pointA[0]) + abs($pointB[1]-$pointA[1]);
    }

    public function calculateLengthWithExpansion(array $pointA, array $pointB, array $emptyLines, array $emptyColumns, int $expandValue): int
    {
        $linesBetweenAandB = range($pointA[0], $pointB[0]);
        $columnsBetweenAandB = range($pointA[1], $pointB[1]);

        $linesMultiplier = count(array_intersect($linesBetweenAandB, $emptyLines));
        $columnsMultiplier = count(array_intersect($columnsBetweenAandB, $emptyColumns));

        return abs($pointB[0]-$pointA[0])+($linesMultiplier*($expandValue-1)) + abs($pointB[1]-$pointA[1]) + ($columnsMultiplier*($expandValue-1));
    }
}
