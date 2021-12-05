<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));

$maxX = 0;
$maxY = 0;
$vents = array_map(function (string $line) use (&$maxX, &$maxY) {
    [$startPos, $endPos] = array_map(fn (string $pos) => array_map(fn (string $num) => (int) $num, explode(',', $pos)), explode(' -> ', $line));
    $maxX = max($maxX, $startPos[0], $endPos[0]);
    $maxY = max($maxY, $startPos[1], $endPos[1]);

    return ['start' => $startPos, 'end' => $endPos];
}, $inputs);

$cnt = 0;
$field = array_fill_keys(range(0, $maxX), array_fill_keys(range(0, $maxY), 0));
foreach ($vents as ['start' => $startPos, 'end' => $endPos]) {
    $horizontal = $startPos[0] != $endPos[0];
    $vertical = $startPos[1] != $endPos[1];

    $xAdd = $horizontal ? ($startPos[0] < $endPos[0] ? 1 : -1) : 0;
    $yAdd = $vertical ? ($startPos[1] < $endPos[1] ? 1 : -1) : 0;

    // I hate this, but my brain is struggling to come up with a clean solution for this loop rn
    $x = $startPos[0] - $xAdd;
    $y = $startPos[1] - $yAdd;
    while($x !== $endPos[0] || $y !== $endPos[1]) {
        $x += $xAdd;
        $y += $yAdd;

        $field[$x][$y]++;
        if ($field[$x][$y] === 2) {
            $cnt++;
        }
    }
}

echo $cnt . PHP_EOL;
