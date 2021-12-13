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
    $valid += isset($passport['byr']) && preg_match('/^(19[2-90]\d)|(200[0-2])$/', $passport['byr']) === 1 &&
        isset($passport['iyr']) && preg_match('/^(201\d)|(2020)$/', $passport['iyr']) === 1 &&
        isset($passport['eyr']) && preg_match('/^(202\d)|(2030)$/', $passport['eyr']) === 1 &&
        isset($passport['hgt']) && preg_match('/^(((1[5-8]\d)|(19[0-3]))cm)|(((59)|(6\d)|(7[0-6]))in)$/', $passport['hgt']) === 1 &&
        isset($passport['hcl']) && preg_match('/^#[0-9a-f]{6}$/', $passport['hcl']) === 1 &&
        isset($passport['ecl']) && preg_match('/^(amb)|(blu)|(brn)|(gry)|(grn)|(hzl)|(oth)$/', $passport['ecl']) === 1 &&
        isset($passport['pid']) && preg_match('/^\d{9}$/', $passport['pid']) === 1 ? 1 : 0;
}

echo $valid . PHP_EOL;