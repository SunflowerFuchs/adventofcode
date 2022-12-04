<?php

define('PRIORITIES', array_combine(array_merge(range('a', 'z'), range('A', 'Z')), range(1, 52)));

$lines = array_filter(explode("\n", file_get_contents(__DIR__ . '/input.txt')));

$totalScore = 0;
foreach ($lines as $line) {
    [$c1, $c2] = str_split($line, strlen($line) / 2);
    $c1chars = array_unique(str_split($c1));
    $c2chars = array_unique(str_split($c2));
    $common = array_values(array_intersect($c1chars, $c2chars))[0];
    $totalScore += PRIORITIES[$common];
}

printf("Total score: %d", $totalScore);