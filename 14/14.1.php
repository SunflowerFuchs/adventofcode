<?php

// Part 2 has optimized code
// Part 2 is the same goal with more steps, but I've decided to leave this part alone
// after figuring out doing the permutations for 40 steps is not feasible haha

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
[$template] = array_splice($inputs, 0, 1);

$replacements = [];
foreach ($inputs as $replacement) {
    [$haystack, $insert] = explode(' -> ', $replacement);
    $replacements[$haystack] = substr($haystack, 0, 1) . $insert . substr($haystack, 1);
}

for ($step = 1; $step <= 10; $step++) {
    $inserted = '';
    for ($offset = 0; $offset < strlen($template) - 1; $offset++) {
        $insert = strtr(substr($template, $offset, 2), $replacements);
        $inserted .= $offset === 0 ? $insert : substr($insert, 1);
    }
    $template = $inserted;
}

$quantities = array_count_values(str_split($template));
arsort($quantities);

$mostCommon = array_key_first($quantities);
$leastCommon = array_key_last($quantities);

$sum = $quantities[$mostCommon] - $quantities[$leastCommon];
echo $sum . PHP_EOL;