<?php

namespace App\Services;

class Day13Services
{
    public function getGrids(array $lines): array
    {
        $currentGrid = 0;
        $grids = [];

        foreach ($lines as $line) {
            if ('' === $line) {
                $currentGrid++;
            }
            else {
                $grids[$currentGrid][] = $line;
            }
        }

        return $grids;
    }

    public function getVerticalStrings(array $grid): array
    {
        $fullArrayGrid = [];
        $columnsStrings = [];
        foreach ($grid as $key => $line) {
            $fullArrayGrid[$key] = str_split($line);
        }

        for($i = 0; $i < count($fullArrayGrid[0]); $i++) {
            $columnsStrings[$i] = implode('', array_column($fullArrayGrid, $i));
        }

        return $columnsStrings;
    }

    public function getSymmetryStart(array $grid): ?int
    {
        foreach ($grid as $key => $line) {
            if (isset($grid[$key+1]) && $line === $grid[$key+1]) {
                // the pattern must go till one end of the grid (right or left)
                $isLeftPartBigger = $key+1 > count($grid)/2;
                if ($isLeftPartBigger) { // if left side is bigger, then there is some defect, we only need the same amount of lines that the end of the mirrored pattern
                    $arrayPart2 = array_slice($grid, $key+1);
                    $arrayPart1 = array_slice($grid, $key - count($arrayPart2)+1, count($arrayPart2));
                    $arrayPart1 = array_reverse($arrayPart1);
                } else { // if left side is shorter, we truncate the mirrored lines to the size of the pattern
                    $arrayPart1 = array_reverse(array_slice($grid, 0, $key+1));
                    $arrayPart2 = array_slice($grid, $key+1, count($arrayPart1));
                }

                if ($arrayPart1 === $arrayPart2) {
                    return $key;
                }
            }
        }

        return null;
    }
}
