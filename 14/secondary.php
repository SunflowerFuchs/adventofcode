<?php

const SPAWNER_COORD = [500, 0];

class Rock
{
}

class Grain
{
    protected int $x = SPAWNER_COORD[0];
    protected int $y = SPAWNER_COORD[1];

    public function __construct(array &$grid)
    {
        $grid[$this->y][$this->x] = $this;
    }

    public function move(array &$grid): int
    {
        if (empty($grid[$this->y + 1][$this->x])) {
            $grid[$this->y][$this->x] = null;
            $grid[++$this->y][$this->x] = $this;
            return 1;
        } elseif (empty($grid[$this->y + 1][$this->x - 1])) {
            $grid[$this->y][$this->x] = null;
            $grid[++$this->y][--$this->x] = $this;
            return 1;
        } elseif (empty($grid[$this->y + 1][$this->x + 1])) {
            $grid[$this->y][$this->x] = null;
            $grid[++$this->y][++$this->x] = $this;
            return 1;
        }

        if ($this->x === SPAWNER_COORD[0] && $this->y === SPAWNER_COORD[1]) {
            return -1;
        }

        return 0;
    }
}

function printGrid($grid)
{
    foreach (range(min(array_keys($grid)), max(array_keys($grid))) as $y) {
        $row = $grid[$y];
        foreach (range(min(array_keys($row)), max(array_keys($row))) as $x) {
            $val = $row[$x];
            echo match (true) {
                $y === SPAWNER_COORD[1] && $x === SPAWNER_COORD[0] => 'O',
                $val instanceof Rock => 'X',
                $val instanceof Grain => 'S',
                default => ' '
            };
        }
        echo "\n";
    }
}

// split file into lines
$structs = array_map(
// split lines into coords
    fn($line) => array_map(
    // split coords into x/y
        fn($group) => array_map(
            fn($num) => intval($num),
            explode(',', $group)
        ),
        explode(' -> ', $line)
    ),
    explode("\n", trim(file_get_contents(__DIR__ . '/input.txt')))
);

$grid = [];
$minX = SPAWNER_COORD[0];
$minY = SPAWNER_COORD[1];
$maxX = SPAWNER_COORD[0];
$maxY = SPAWNER_COORD[1];
foreach ($structs as $coords) {
    for ($i = 1; $i < count($coords); $i++) {
        [$firstX, $firstY] = $coords[$i - 1];
        [$secondX, $secondY] = $coords[$i];
        foreach (range($firstX, $secondX) as $x) {
            $grid[$firstY] ??= [];
            $minX = min($minX, $x);
            $maxX = max($maxX, $x);
            $grid[$firstY] ??= [];
            $grid[$firstY][$x] = new Rock();
        }
        foreach (range($firstY, $secondY) as $y) {
            $grid[$y] ??= [];
            $minY = min($minY, $y);
            $maxY = max($maxY, $y);
            $grid[$y] ??= [];
            $grid[$y][$firstX] = new Rock();
        }
    }
}

$maxY += 2;
$minX -= $maxY + 1;
$maxX += $maxY + 1;
$grid[$maxY] ??= [];
foreach (range($minX, $maxX) as $x) {
    $grid[$maxY][$x] = new Rock();
}

foreach (range($minY, $maxY) as $y) {
    $grid[$y] ??= [];
    foreach (range($minX, $maxX) as $x) {
        $grid[$y][$x] ??= null;
    }
}

//printGrid($grid);
$numGrains = 0;
while (true) {
    $numGrains++;
    $grain = new Grain($grid);
    while (true) {
        $res = $grain->move($grid);
        if ($res === 0) break 1;
        if ($res === -1) break 2;
    }
//    printGrid($grid);
}
printf("Dropped grains until filled: %d\n", $numGrains);