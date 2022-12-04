<?php

$lines = array_filter(explode("\n", file_get_contents(__DIR__ . '/input.txt')));

$numFullOverlaps = 0;
$numOverlaps = 0;
foreach ($lines as $line) {
    [$a1, $a2] = explode(',', $line);
    $a1s = range(...explode('-', $a1));
    $a2s = range(...explode('-', $a2));

    if (count($a1s) > count($a2s)) {
        [$a1s, $a2s] = [$a2s, $a1s];
    }

    $intersection = array_intersect($a1s, $a2s);
    if (count($intersection) === count($a1s)) {
        $numFullOverlaps++;
    }
    if (count($intersection) > 0) {
        $numOverlaps++;
    }
}

printf("Num full overlaps: %d\n", $numFullOverlaps);
printf("Num overlaps: %d\n", $numOverlaps);