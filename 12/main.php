<?php

const START_VAL = 0;
const END_VAL = 27;

// 31 steps for input 2
class Coord
{
    public function __construct(public int $x, public int $y)
    {
    }
}

/**
 * @param Coord[] $curPath
 * @param int[][] $grid
 */
function findShortestPath(array $curPath, array $grid, int $knownShortestPath = -1): array|false
{
    if ($knownShortestPath !== -1 && $knownShortestPath <= count($curPath) + 1) return false;

    $curCoord = $curPath[array_key_last($curPath)];
    $curVal = $grid[$curCoord->y][$curCoord->x]['val'];
    $availableSpots = array_filter([
        new Coord($curCoord->x + 1, $curCoord->y),
        new Coord($curCoord->x, $curCoord->y + 1),
        new Coord($curCoord->x - 1, $curCoord->y),
        new Coord($curCoord->x, $curCoord->y - 1),
    ], fn(Coord $coord) => isset($grid[$coord->y][$coord->x])
        && ($grid[$coord->y][$coord->x]['val'] <= $curVal + 1)
        && !$grid[$coord->y][$coord->x]['visited']);
    if (empty($availableSpots)) {
        return false;
    }

    $shortestPath = false;
    foreach ($availableSpots as $availableSpot) {
        $newPath = [...$curPath, $availableSpot];
        if ($grid[$availableSpot->y][$availableSpot->x]['val'] === END_VAL) {
            return $newPath;
        }

        $newGrid = $grid;
        $newGrid[$availableSpot->y][$availableSpot->x]['visited'] = true;
        $return = findShortestPath($newPath, $newGrid, $knownShortestPath);
        if ($return !== false && (!$shortestPath || count($shortestPath) > count($return))) {
            $shortestPath = $return;
            $knownShortestPath = count($return);
        }
    }

    return $shortestPath;
}

$lines = explode("\n", trim(file_get_contents(__DIR__ . '/input.txt')));
$grid = array_fill_keys(range(0, count($lines) - 1), []);

$startCoords = null;
foreach ($lines as $y => $line) {
    foreach (str_split($line) as $x => $char) {
        $grid[$y][$x] = [
            'val' => match ($char) {
                'S' => START_VAL,
                'E' => END_VAL,
                default => ord($char) - 96
            },
            'visited' => $char === 'S'
        ];
        if ($char === 'S') $startCoords = new Coord($x, $y);
    }
}

$currentPath = [$startCoords];
$path = findShortestPath($currentPath, $grid);
printf("Shortest path: %s\n", count($path) - 1);