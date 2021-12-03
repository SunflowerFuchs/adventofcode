<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
$length = array_reduce($inputs, fn(int $carry, string $bin) => max(strlen($bin), $carry), 0);

function getMostCommon(int $position, array $bins) : int {
    $common = 0;
    foreach ($bins as $bin) {
        $common += (int) substr($bin, $position, 1);
    }
    return round($common / count($bins));
};

$oCandidates = $co2Candidates = $inputs;
for ($i = 0; $i <= $length; $i++) {
    if (count($oCandidates) > 1) {
        $oMostCommon = getMostCommon($i, $oCandidates);
        $oCandidates = array_filter($oCandidates, fn(string $value) => substr($value, $i, 1) == $oMostCommon);
    }

    if (count($co2Candidates) > 1) {
        $co2MostCommon = getMostCommon($i, $co2Candidates) === 1 ? '0' : '1';
        $co2Candidates = array_filter($co2Candidates, fn(string $value) => substr($value, $i, 1) == $co2MostCommon);
    }
}

$oRating = reset($oCandidates);
$co2Rating = reset($co2Candidates);

echo $oRating . PHP_EOL;
echo $co2Rating . PHP_EOL;
echo (bindec($oRating) * bindec($co2Rating)) . PHP_EOL;