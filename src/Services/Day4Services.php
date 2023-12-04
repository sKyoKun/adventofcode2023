<?php
declare(strict_types=1);

namespace App\Services;

class Day4Services
{
    public function getCards(array $lines): array
    {
        $cardsPerLine = [];
        foreach ($lines as $line) {
            $explodedLine = explode(' | ', $line);

            $matchesMyNumbers = [];
            preg_match_all('#\d+#', $explodedLine[1], $matchesMyNumbers);
            $myNumbers = $matchesMyNumbers[0];

            $winningNumbersString = explode(': ', $explodedLine[0]);
            $matchesWinningNumbers = [];
            preg_match_all('#\d+#', $winningNumbersString[1], $matchesWinningNumbers);

            $matchesCurrentCard = [];
            preg_match_all('#\d+#', $winningNumbersString[0], $matchesCurrentCard);
            $currentCard = $matchesCurrentCard[0][0];

            $winningNumbers = $matchesWinningNumbers[0];
            $cardsPerLine[$currentCard]['winning'] = $winningNumbers;
            $cardsPerLine[$currentCard]['mycards'] = $myNumbers;
        }

        return $cardsPerLine;
    }

    public function calculatePoints(array $cardsPerLine)
    {
        $totalPoints = 0;
        foreach ($cardsPerLine as $game) {
            $intersect = array_intersect($game['winning'], $game['mycards']);
            if (count($intersect) > 0) {
                $currentPoint = 1;
                array_pop($intersect);
                foreach ($intersect as $item) {
                    $currentPoint *= 2;
                }
                $totalPoints += $currentPoint;
            }
        }

        return $totalPoints;
    }

    public function calculateScratchboards(array $cardsPerLine)
    {
        $scratchCard = [];
        foreach ($cardsPerLine as $gameNumber => $game) {
            $multiplier = isset($scratchCard[$gameNumber]) ? $scratchCard[$gameNumber] + 1 : 1;
            $scratchCard[$gameNumber] = $multiplier;

            $intersect = array_intersect($game['winning'], $game['mycards']);
            for ($i = $gameNumber + 1; $i <= ($gameNumber + count($intersect)); ++$i) {
                $scratchCard[$i] = isset($scratchCard[$i]) ? $scratchCard[$i] + $multiplier : $multiplier;
            }
        }

        return array_sum($scratchCard);
    }
}
