<?php
declare(strict_types=1);

namespace App\Services;

class Day7Services
{
    public const CARD_VALUES = ['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'];
    public const CARD_VALUES_WITH_JOKER = ['A', 'K', 'Q', 'T', '9', '8', '7', '6', '5', '4', '3', '2', 'J'];
    public const RANK_VALUES = [
        'FiveKind' => 0,
        'FourKind' => 1,
        'FullHouse' => 2,
        'ThreeKind' => 3,
        'TwoPairs' => 4,
        'OnePair' => 5,
        'HighCard' => 6,
    ];

    private bool $useJoker = false;

    public function parseHandAndBid(array $lines)
    {
        $handAndBid = [];
        foreach ($lines as $line) {
            $explodedLine = explode(' ', $line);
            $handAndBid['' . $explodedLine[0]] = (int) $explodedLine[1];
        }

        return $handAndBid;
    }

    public function sortHands(array $hands)
    {
        uksort($hands, [$this, 'compareHand']);

        return $hands;
    }

    public function calculateTotalWinning(array $hands)
    {
        $currentHand = count($hands);
        $totalWinning = 0;
        foreach ($hands as $hand => $bid) {
            $totalWinning += $bid * $currentHand;
            --$currentHand;
        }

        return $totalWinning;
    }

    public function compareHand(string $handA, string $handB)
    {
        $rankValueA = self::RANK_VALUES[$this->determineHandType($handA)];
        $rankValueB = self::RANK_VALUES[$this->determineHandType($handB)];

        $cardValues = $this->useJoker ? self::CARD_VALUES_WITH_JOKER : self::CARD_VALUES;
        if ($rankValueA === $rankValueB) {
            for ($i = 0; $i < strlen($handA); ++$i) {
                if (array_search($handA[$i], $cardValues, true) === array_search($handB[$i], $cardValues, true)) {
                    continue;
                }

                return (array_search($handA[$i], $cardValues, true) < array_search($handB[$i], $cardValues, true)) ? -1 : 1;
            }
        }

        return ($rankValueA < $rankValueB) ? -1 : 1;
    }

    public function determineHandType(string $hand)
    {
        $values = [];
        for ($i = 0; $i < strlen($hand); ++$i) {
            $values[$hand[$i]] = (isset($values[$hand[$i]])) ? $values[$hand[$i]] + 1 : 1;
        }
        if ($this->useJoker) {
            if (array_key_exists('J', $values)) {
                $numberOfJ = $values['J'];
                if (5 !== $numberOfJ) { // handle case of JJJJJ
                    unset($values['J']);
                    $keyMax = array_search(max($values), $values, true);
                    $values[$keyMax] += $numberOfJ;
                }
            }
        }
        if (1 === count($values)) {
            return 'FiveKind';
        } elseif (2 === count($values)) {
            if (4 === max($values)) {
                return 'FourKind';
            } elseif (3 === max($values)) {
                return 'FullHouse';
            }
        } elseif (3 === count($values)) {
            if (3 === max($values)) {
                return 'ThreeKind';
            } elseif (2 === max($values)) {
                return 'TwoPairs';
            }
        } elseif (4 === count($values)) {
            return 'OnePair';
        } else {
            return 'HighCard';
        }
    }

    public function setUseJoker(bool $useJoker): void
    {
        $this->useJoker = $useJoker;
    }
}
