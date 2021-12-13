<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
$paths = array_map(fn(string $path) => explode('-', $path), $inputs);

$points = [];
foreach ($paths as [$start, $end]) {
    $points[] = $start;
    $points[] = $end;
}
$points = array_unique($points);

$possibilities = array_fill_keys($points, []);
foreach ($paths as [$start, $end]) {
    $possibilities[$start][] = $end;
    $possibilities[$end][] = $start;
}

function countRoutes(string $startPoint, array $possibilities, array $visited = []) : int {
    if (!ctype_upper($startPoint) && isset($visited[$startPoint])) {
        return 0;
    }
    $visited[$startPoint] = true;

    $ends = 0;
    foreach ($possibilities[$startPoint] as $cave) {
        if ($cave === 'end') {
            $ends++;
        } else {
            $ends += countRoutes($cave, $possibilities, $visited);
        }
    }

    return $ends;
}

$numPaths = countRoutes('start', $possibilities);

echo $numPaths . PHP_EOL;