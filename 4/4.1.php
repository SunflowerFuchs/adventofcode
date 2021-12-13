<?php

$inputs = explode("\n", file_get_contents('input.txt'));

// Parsing
$counter = 0;
$passports = [0 => []];
foreach ($inputs as $line) {
    if (empty($line)) {
        $counter++;
        $passports[$counter] = [];
        continue;
    }

    $fields = explode(' ', $line);
    foreach ($fields as $field) {
        [$fieldName, $fieldValue] = explode(':', $field);
        $passports[$counter][$fieldName] = $fieldValue;
    }
}

// Validation
$valid = 0;
foreach ($passports as $passport) {
    $valid += isset($passport['byr']) &&
    isset($passport['iyr']) &&
    isset($passport['eyr']) &&
    isset($passport['hgt']) &&
    isset($passport['hcl']) &&
    isset($passport['ecl']) &&
    isset($passport['pid']) ? 1 : 0;
}

echo $valid . PHP_EOL;