<?php
declare(strict_types=1);

namespace App\Services;

class Day6Services
{
    public function getRaces(array $input): array
    {
        $times = [];
        $records = [];
        preg_match_all('#\d+#', $input[0], $times);
        preg_match_all('#\d+#', $input[1], $records);

        return array_combine($times[0], $records[0]);
    }

    public function getRace(array $input): array
    {
        $times = [];
        $records = [];
        preg_match_all('#\d+#', $input[0], $times);
        preg_match_all('#\d+#', $input[1], $records);

        $time = implode('', $times[0]);
        $record = implode('', $records[0]);

        return [$time => $record];
    }

    public function getWaysToBeatRecord(int $time, int $distance): int
    {
        $waysToBeatRaceRecord = 0;
        for ($i = 0; $i <= $time; ++$i) {
            if (($time - $i) * $i > $distance) {
                ++$waysToBeatRaceRecord;
            }
        }

        return $waysToBeatRaceRecord;
    }
}
