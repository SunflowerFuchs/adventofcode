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

function countRoutes(
    string $startPoint,
    array $possibilities,
    array $visited = [],
    bool $hasUsedDoubleVisit = false
): int {
    $visited[$startPoint] = true;

    $ends = 0;
    foreach ($possibilities[$startPoint] as $cave) {
        if ($cave === 'end') {
            $ends++;
        } elseif (!ctype_lower($cave) || !isset($visited[$cave])) {
            $ends += countRoutes($cave, $possibilities, $visited, $hasUsedDoubleVisit);
        }

        if (!$hasUsedDoubleVisit && ctype_lower($cave) && isset($visited[$cave]) && $cave !== 'start' && $cave !== 'end') {
            $ends += countRoutes($cave, $possibilities,
                array_filter($visited, fn($vCave) => $vCave !== $cave, ARRAY_FILTER_USE_KEY), true);
        }
    }

    return $ends;
}

$numPaths = countRoutes('start', $possibilities);

echo $numPaths . PHP_EOL;