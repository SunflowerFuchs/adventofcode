<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
$field = array_map(fn(string $row) => array_map(fn ($num) => (int)$num, str_split($row)), $inputs);

$lowPoints = [];
foreach ($field as $rowId => $row){
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

$sum = 0;
foreach ($lowPoints as [$rowId, $colId]) {
    $sum += $field[$rowId][$colId] + 1;
}

echo $sum . PHP_EOL;