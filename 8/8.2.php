<?php

require_once 'helpers.php';

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));

$count = 0;
foreach ($inputs as $set) {
    [$numbers, $target] = array_map(fn($array) => array_filter(explode(' ', $array)), explode('|', $set));
    $numbers = array_map('sortString', $numbers);
    $target = array_map('sortString', $target);

    $nums = array_fill(0, 10, null);
    [$nums[1]] = array_values(array_filter($numbers, fn($wires) => strlen($wires) === 2));
    [$nums[4]] = array_values(array_filter($numbers, fn($wires) => strlen($wires) === 4));
    [$nums[7]] = array_values(array_filter($numbers, fn($wires) => strlen($wires) === 3));
    [$nums[8]] = array_values(array_filter($numbers, fn($wires) => strlen($wires) === 7));

    $mappedWires = array_fill_keys(range(0, 9), null);

    $topWire = array_values(array_filter(str_split($nums[7]), fn($char) => !str_contains($nums[1], $char)))[0];
    $remainingWires = array_values(array_filter(range('a', 'g'), fn($char) => $char !== $topWire));
    $permutations = array_map(fn($perm) => $topWire . $perm, generatePermutations($remainingWires));

    // No idea what i'm trying to do here
    foreach ($permutations as $permutation) {
        $counter = 0;
        $wires = [];
        foreach (str_split($permutation) as $char) {
            $wires[$char] = WIRE_MAPPING[$counter++];
        }

        $combined = array_map(fn($number) => array_reduce(str_split($number),
            fn($carry, $char) => $wires[$char] | $carry, 0), $numbers);
        $intersect = array_intersect($combined, NUMBER_MAPPING);
        $reverse = array_flip(NUMBER_MAPPING);
        if (count($intersect) === 10) {
            $mapped = [];
            foreach ($combined as $position => $value) {
                $mapped[$numbers[$position]] = $reverse[$value];
            }

            $count += (int)implode('', array_map(fn($num) => $mapped[$num], $target));
            continue 2;
        }
    }
}

echo $count . PHP_EOL;