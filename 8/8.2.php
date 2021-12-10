<?php

require_once 'helpers.php';

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));

$count = 0;
foreach ($inputs as $set) {
    [$numbers, $target] = array_map(fn($array) => array_filter(explode(' ', $array)), explode('|', $set));
    $numbers = array_map('sortString', $numbers);
    $target = array_map('sortString', $target);

    [$one] = array_values(array_filter($numbers, fn($wires) => strlen($wires) === 2));
    [$seven] = array_values(array_filter($numbers, fn($wires) => strlen($wires) === 3));

    $mappedWires = array_fill_keys(range(0, 9), null);

    // Find the first wire and generate the permutations for the remaining wires
    $topWire = array_values(array_filter(str_split($seven), fn($char) => !str_contains($one, $char)))[0];
    $remainingWires = array_values(array_filter(range('a', 'g'), fn($char) => $char !== $topWire));
    $permutations = array_map(fn($perm) => $topWire . $perm, generatePermutations($remainingWires));

    // Do some extra filtering
    $oneChars = array_fill_keys(str_split($one), true);
    $permutations = array_filter($permutations, fn ($perm)=> isset($oneChars[substr($perm, 2, 1)]));
    $permutations = array_filter($permutations, fn ($perm)=> isset($oneChars[substr($perm, 5, 1)]));

    // Go through the remaining permutations and just try them all
    // After the previous filtering step there's less than 50 left, so this is fast enough
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