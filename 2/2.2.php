<?php

$inputs = explode("\n", file_get_contents('input.txt'));
$inputs = array_map(fn ($line) => explode(' ', $line), array_filter($inputs));

$depth = 0;
$position = 0;
$aim = 0;
foreach ($inputs as [0 => $action, 1 => $value]) {
    switch ($action) {
        case 'forward':
            $position += $value;
            $depth += $value * $aim;
            break;
        case 'up':
            $aim -= $value;
            break;
        case 'down':
            $aim += $value;
            break;
    }
}

echo $depth * $position;