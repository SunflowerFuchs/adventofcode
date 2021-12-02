<?php

$inputs = explode("\n", file_get_contents('input.txt'));
$inputs = array_map(fn ($line) => explode(' ', $line), array_filter($inputs));

$depth = 0;
$location = 0;
foreach ($inputs as [0 => $action, 1 => $value]) {
    switch ($action) {
        case 'forward':
            $location += $value;
            break;
        case 'up':
            $depth -= $value;
            break;
        case 'down':
            $depth += $value;
            break;
    }
}

echo $depth * $location;