<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
$trees = array_map(fn($row) => array_map(fn($tree) => $tree === '#', str_split($row)), $inputs);
$height = count($trees);
$width = count($trees[0]);

$hits = 0;
for ($step = 0; $step < $height; $step++) {
    $x = (3 * $step) % $width;
    if ($trees[$step][$x]) {
        $hits++;
    }
}

echo $hits . PHP_EOL;