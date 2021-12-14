<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
[$template] = array_splice($inputs, 0, 1);

$replacements = [];
foreach ($inputs as $replacement) {
    [$haystack, $insert] = explode(' -> ', $replacement);
    $replacements[$haystack] = substr($haystack, 0, 1) . $insert . substr($haystack, 1);
}

$pairs = [];
for ($offset = 0; $offset < strlen($template) - 1; $offset++) {
    $pair = substr($template, $offset, 2);
    $pairs[$pair] = ($pairs[$pair] ?? 0) + 1;
}

$lastPair = '';
for ($step = 0; $step < 40; $step++) {
    $newPairs = [];
    foreach ($pairs as $pair => $count) {
        $target = strtr($pair, $replacements);
        $targetPairs = [substr($target, 0, 2), substr($target, 1)];
        foreach ($targetPairs as $targetPair) {
            $newPairs[$targetPair] = ($newPairs[$targetPair] ?? 0) + $count;
            $lastPair = $targetPair;
        }
    }
    $pairs = $newPairs;
}

$elements = [];
foreach ($pairs as $pair => $count) {
    $element = substr($pair, 0, 1);
    $elements[$element] = ($elements[$element] ?? 0) + $count;
}
// The last char will always be the same
$elements[substr($template, -1)]++;

arsort($elements);

var_dump($elements);

$mostCommon = array_key_first($elements);
$leastCommon = array_key_last($elements);

$sum = $elements[$mostCommon] - $elements[$leastCommon];
echo $sum . PHP_EOL;