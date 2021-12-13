<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
$octopi = array_map(fn(string $line) => array_map(fn($octopus) => ['energy' => (int)$octopus, 'flashed' => false],
    str_split($line)), $inputs);

function energizeOctopus(array &$octopi, int $x, int $y): int
{
    $flashes = 0;
    $octopi[$x][$y]['energy']++;
    if ($octopi[$x][$y]['energy'] < 10 || $octopi[$x][$y]['flashed']) {
        return 0;
    }

    $flashes += 1;
    $octopi[$x][$y]['flashed'] = true;
    for ($xOff = -1; $xOff <= 1; $xOff++) {
        for ($yOff = -1; $yOff <= 1; $yOff++) {
            if (($xOff === 0 && $yOff === 0) || !isset($octopi[$x + $xOff][$y + $yOff])) {
                continue;
            }
            $flashes += energizeOctopus($octopi, $x + $xOff, $y + $yOff);
        }
    }

    return $flashes;
}

function resetFlashedOctopi(array &$octopi) {
    $octopi = array_map(fn($row) => array_map(fn($octopus) => $octopus['flashed'] ? [
        'energy' => 0,
        'flashed' => false
    ] : $octopus, $row), $octopi);
}

$step = 0;
$target = count($octopi) * count($octopi[0]);
while (true) {
    $step++;
    $flashes = 0;
    for ($y = 0; $y < count($octopi); $y++) {
        for ($x = 0; $x < count($octopi[$y]); $x++) {
            $flashes += energizeOctopus($octopi, $x, $y);
        }
    }
    if ($flashes === $target) break;
    resetFlashedOctopi($octopi);
}

echo $step . PHP_EOL;