<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
$trees = array_map(fn($row) => array_map(fn($tree) => $tree === '#', str_split($row)), $inputs);
$height = count($trees);
$width = count($trees[0]);

$slopes = [
    [1, 1],
    [3, 1],
    [5, 1],
    [7, 1],
    [1, 2],
];
$totalHits = 1;
foreach ($slopes as [$xOff, $yOff]) {
    $hits = 0;
    for ($step = 0; $step < $height; $step++) {
        $x = ($xOff * $step) % $width;
        $y = $yOff * $step;
        if ($trees[$y][$x] ?? false) {
            $hits++;
        }
    }
    $totalHits *= $hits;
}

echo $totalHits . PHP_EOL;