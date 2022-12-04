<?php

define('PRIORITIES', array_combine(array_merge(range('a', 'z'), range('A', 'Z')), range(1, 52)));

$lines = array_filter(explode("\n", file_get_contents(__DIR__ . '/input.txt')));

$totalScore = 0;
$group = [];
foreach ($lines as $line) {
    $group[] = array_unique(str_split($line));
    if (count($group) !== 3) {
        continue;
    }

    $common = array_values(array_intersect($group[0], $group[1], $group[2]))[0];
    $totalScore += PRIORITIES[$common];
    $group = [];
}

printf("Total score: %d", $totalScore);