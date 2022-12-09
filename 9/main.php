<?php

const NUM_PIECES = 9;

class Position
{
    public function __construct(public int $x = 0, public int $y = 0)
    {
    }
}

class Rope
{
    protected array $pieces = [];
    protected array $tailPositions = [];

    public function __construct(int $length = 1)
    {
        for ($i = 0; $i <= $length; $i++) {
            $this->pieces[] = new Position();
        }
    }

    public function moveHead(int $x = 0, int $y = 0): void
    {
        while ($x !== 0) {
            $change = ($x > 0 ? 1 : -1);
            $this->pieces[0]->x += $change;
            $this->pullPieces();
            $x += -$change;
        }

        while ($y !== 0) {
            $change = ($y > 0 ? 1 : -1);
            $this->pieces[0]->y += $change;
            $this->pullPieces();
            $y += -$change;
        }

        return;
    }

    protected function pullPieces(): void
    {
        for ($i = 1; $i < count($this->pieces); $i++) {
            $this->pieces[$i] = $this->pullPiece($this->pieces[$i - 1], $this->pieces[$i]);
        }

        $tail = $this->pieces[$i - 1];
        $this->tailPositions[sprintf('%d:%d', $tail->x, $tail->y)] = true;
    }

    protected function pullPiece(Position $lead, Position $follow): Position
    {
        $xDistance = $lead->x - $follow->x;
        $yDistance = $lead->y - $follow->y;
        $totalDistance = abs($xDistance) + abs($yDistance);
        switch ($totalDistance) {
            case 4:
            case 3:
                // Diagonal move required
            case 2:
                if (abs($xDistance) === 1 && abs($yDistance) === 1) {
                    // Diagonally adjacent
                    break;
                }

                // Horizontal move
                $follow->x += round($xDistance / 2);
                $follow->y += round($yDistance / 2);
                break;
            case 1:
                // Direcly adjacent
            case 0:
                // Overlapping
                break;
        }

        return $follow;
    }

    public function numTailPositions(): int
    {
        return count($this->tailPositions);
    }
}

$lines = array_map(fn($line) => explode(' ', $line), explode("\n", trim(file_get_contents(__DIR__ . '/input.txt'))));

$rope = new Rope(NUM_PIECES);
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

printf("Total tail positions: %d\n", $rope->numTailPositions());