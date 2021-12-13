<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));

$highest = 0;
foreach ($inputs as $input) {
    $row = bindec(strtr(substr($input, 0, 7), ['F' => 0, 'B' => 1]));
    $column = bindec(strtr(substr($input, 7), ['L' => 0, 'R' => 1]));
    $seatId = ($row * 8) + $column;
    $highest = max($highest, $seatId);
}

echo $highest . PHP_EOL;