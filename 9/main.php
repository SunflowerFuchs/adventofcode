<?php

class Position
{
    public function __construct(public int $x = 0, public int $y = 0)
    {
    }
}

class Rope
{
    protected array $tailPositions = [];

    public function __construct(protected Position $headPos = new Position(), protected Position $tailPos = new Position())
    {
    }

    public function moveHead(int $x = 0, int $y = 0): void
    {
        while ($x !== 0) {
            $change = ($x > 0 ? 1 : -1);
            $this->headPos->x += $change;
            $this->pullTail();
            $x += -$change;
        }

        while ($y !== 0) {
            $change = ($y > 0 ? 1 : -1);
            $this->headPos->y += $change;
            $this->pullTail();
            $y += -$change;
        }

        return;
    }

    protected function pullTail(): void
    {
        $xDistance = $this->headPos->x - $this->tailPos->x;
        $yDistance = $this->headPos->y - $this->tailPos->y;
        $totalDistance = abs($xDistance) + abs($yDistance);
        switch ($totalDistance) {
            case 3:
                // Diagonal move required
            case 2:
                if (abs($xDistance) === 1 && abs($yDistance) === 1) {
                    // Diagonally adjacent
                    break;
                }

                // Horizontal move
                $this->tailPos->x += round($xDistance / 2);
                $this->tailPos->y += round($yDistance / 2);
                break;
            case 1:
                // Direcly adjacent
            case 0:
                // Overlapping
                break;
        }

        $this->tailPositions[] = sprintf('%d:%d', $this->tailPos->x, $this->tailPos->y);
    }

    public function countTailPositions(): int
    {
        return count(array_unique($this->tailPositions));
    }
}

$lines = array_map(fn($line) => explode(' ', $line), explode("\n", trim(file_get_contents(__DIR__ . '/input.txt'))));

$rope = new Rope();
foreach ($lines as [$direction, $distance]) {
    $distance = intval($distance);

    [$x, $y] = match ($direction) {
        'U' => [0, -$distance],
        'D' => [0, $distance],
        'L' => [-$distance, 0],
        'R' => [$distance, 0],
    };
    $rope->moveHead($x, $y);
}

printf("Total tail positions: %d\n", $rope->countTailPositions());