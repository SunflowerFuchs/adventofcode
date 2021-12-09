<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
$field = array_map(fn(string $row) => array_map(fn($num) => (int)$num, str_split($row)), $inputs);

$lowPoints = [];
foreach ($field as $rowId => $row) {
    foreach ($row as $colId => $value) {
        $lowest = true;
        if (isset($field[$rowId - 1])) {
            $lowest = $lowest && ($field[$rowId - 1][$colId] > $value);
        }
        if (isset($field[$rowId + 1])) {
            $lowest = $lowest && ($field[$rowId + 1][$colId] > $value);
        }
        if (isset($row[$colId - 1])) {
            $lowest = $lowest && ($row[$colId - 1] > $value);
        }
        if (isset($row[$colId + 1])) {
            $lowest = $lowest && ($row[$colId + 1] > $value);
        }

        if ($lowest) {
            $lowPoints[] = [$rowId, $colId];
        }
    }
}

function markBasins(array $counted, array $field, int $rowId, int $colId): array
{
    $val = $field[$rowId][$colId];
    if ($val === 9) {
        return $counted;
    }

    $counted[$rowId][$colId] = true;
    if (isset($field[$rowId - 1]) && $field[$rowId - 1][$colId] > $val) {
        $counted = markBasins($counted, $field, $rowId - 1, $colId);
    }
    if (isset($field[$rowId + 1]) && $field[$rowId + 1][$colId] > $val) {
        $counted = markBasins($counted, $field, $rowId + 1, $colId);
    }
    if (isset($field[$rowId][$colId - 1]) && $field[$rowId][$colId - 1] > $val) {
        $counted = markBasins($counted, $field, $rowId, $colId - 1);
    }
    if (isset($field[$rowId][$colId + 1]) && $field[$rowId][$colId + 1] > $val) {
        $counted = markBasins($counted, $field, $rowId, $colId + 1);
    }

    return $counted;
}

$basins = [];
$height = count($field);
$width = count($field[0]);
foreach ($lowPoints as [$rowId, $colId]) {
    $emptyField = array_fill_keys(range(0, $height), array_fill_keys(range(0, $width), false));
    $basin = markBasins($emptyField, $field, $rowId, $colId);
    $basins[] = array_reduce($basin, fn(int $sum, array $row) => $sum + array_reduce($row,
            fn(int $rowSum, bool $counted) => $rowSum + ($counted ? 1 : 0), 0), 0);
}

rsort($basins);
$sum = $basins[0] * $basins[1] * $basins[2];
echo $sum . PHP_EOL;