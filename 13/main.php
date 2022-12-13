<?php

$pairs = array_map(fn($pair) => array_map(fn($str) => json_decode($str), explode("\n", $pair)), explode("\n\n", trim(file_get_contents(__DIR__ . '/input.txt'))));

function isCorrectOrder(array $first, array $second): int
{
    for ($i = 0; $i < count($first); $i++) {
        if (!isset($second[$i])) return 1;
        $firstVal = $first[$i];
        $secondVal = $second[$i];

        // unify types
        if (is_array($firstVal) && !is_array($secondVal)) {
            $secondVal = [$secondVal];
        } elseif (!is_array($firstVal) && is_array($secondVal)) {
            $firstVal = [$firstVal];
        }

        if (is_array($firstVal)) {
            $res = isCorrectOrder($firstVal, $secondVal);
            if ($res !== 0) return $res;
        } elseif ($firstVal !== $secondVal) {
            return $firstVal < $secondVal ? -1 : 1;
        }
    }

    if (count($first) === count($second)) return 0;

    return -1;
}

$sumIndices = 0;
foreach ($pairs as $index => [$first, $second]) {
    if (isCorrectOrder($first, $second) === -1) {
        $sumIndices += $index + 1;
    }
}

printf("Sum indices: %d\n", $sumIndices);

$allPairs = array_reduce($pairs, fn($carry, $pairs) => array_merge($carry, $pairs), []);
$dividerPackets = [
    [[2]],
    [[6]]
];
$allPairs = array_merge($allPairs, $dividerPackets);
usort($allPairs, 'isCorrectOrder');
$decoderKey = 1;
foreach ($allPairs as $index => $pair) {
    if (in_array($pair, $dividerPackets)) $decoderKey *= $index + 1;
}

printf("Decoder key: %d\n", $decoderKey);