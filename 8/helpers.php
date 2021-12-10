<?php


const WIRE_MAPPING = [
    0 => 1 << 0,
    1 => 1 << 1,
    2 => 1 << 2,
    3 => 1 << 3,
    4 => 1 << 4,
    5 => 1 << 5,
    6 => 1 << 6,
];

const NUMBER_MAPPING = [
    0 => WIRE_MAPPING[0] | WIRE_MAPPING[1] | WIRE_MAPPING[2] | WIRE_MAPPING[4] | WIRE_MAPPING[5] | WIRE_MAPPING[6],
    1 => WIRE_MAPPING[2] | WIRE_MAPPING[5],
    2 => WIRE_MAPPING[0] | WIRE_MAPPING[2] | WIRE_MAPPING[3] | WIRE_MAPPING[4] | WIRE_MAPPING[6],
    3 => WIRE_MAPPING[0] | WIRE_MAPPING[2] | WIRE_MAPPING[3] | WIRE_MAPPING[5] | WIRE_MAPPING[6],
    4 => WIRE_MAPPING[1] | WIRE_MAPPING[2] | WIRE_MAPPING[3] | WIRE_MAPPING[5],
    5 => WIRE_MAPPING[0] | WIRE_MAPPING[1] | WIRE_MAPPING[3] | WIRE_MAPPING[5] | WIRE_MAPPING[6],
    6 => WIRE_MAPPING[0] | WIRE_MAPPING[1] | WIRE_MAPPING[3] | WIRE_MAPPING[4] | WIRE_MAPPING[5] | WIRE_MAPPING[6],
    7 => WIRE_MAPPING[0] | WIRE_MAPPING[2] | WIRE_MAPPING[5],
    8 => WIRE_MAPPING[0] | WIRE_MAPPING[1] | WIRE_MAPPING[2] | WIRE_MAPPING[3] | WIRE_MAPPING[4] | WIRE_MAPPING[5] | WIRE_MAPPING[6],
    9 => WIRE_MAPPING[0] | WIRE_MAPPING[1] | WIRE_MAPPING[2] | WIRE_MAPPING[3] | WIRE_MAPPING[5] | WIRE_MAPPING[6],
];

function displayNumber(int $number): void
{
    $digits = str_split((string)$number);
    $rows = array_fill_keys(range(0, 8), '');

    foreach ($digits as $pos => $digit) {
        $wires = NUMBER_MAPPING[$digit];

        if (($wires & WIRE_MAPPING[0]) === WIRE_MAPPING[0]) {
            $rows[0] .= ' XXX ';
        } else {
            $rows[0] .= '     ';
        }

        if (($wires & WIRE_MAPPING[1]) === WIRE_MAPPING[1]) {
            if (($wires & WIRE_MAPPING[2]) === WIRE_MAPPING[2]) {
                $rows[1] .= 'X   X';
                $rows[2] .= 'X   X';
                $rows[3] .= 'X   X';
            } else {
                $rows[1] .= 'X    ';
                $rows[2] .= 'X    ';
                $rows[3] .= 'X    ';
            }
        } else {
            if (($wires & WIRE_MAPPING[2]) === WIRE_MAPPING[2]) {
                $rows[1] .= '    X';
                $rows[2] .= '    X';
                $rows[3] .= '    X';
            } else {
                $rows[1] .= '     ';
                $rows[2] .= '     ';
                $rows[3] .= '     ';
            }
        }

        if (($wires & WIRE_MAPPING[3]) === WIRE_MAPPING[3]) {
            $rows[4] .= ' XXX ';
        } else {
            $rows[4] .= '     ';
        }

        if (($wires & WIRE_MAPPING[4]) === WIRE_MAPPING[4]) {
            if (($wires & WIRE_MAPPING[5]) === WIRE_MAPPING[5]) {
                $rows[5] .= 'X   X';
                $rows[6] .= 'X   X';
                $rows[7] .= 'X   X';
            } else {
                $rows[5] .= 'X    ';
                $rows[6] .= 'X    ';
                $rows[7] .= 'X    ';
            }
        } else {
            if (($wires & WIRE_MAPPING[5]) === WIRE_MAPPING[5]) {
                $rows[5] .= '    X';
                $rows[6] .= '    X';
                $rows[7] .= '    X';
            } else {
                $rows[5] .= '     ';
                $rows[6] .= '     ';
                $rows[7] .= '     ';
            }
        }

        if (($wires & WIRE_MAPPING[6]) === WIRE_MAPPING[6]) {
            $rows[8] .= ' XXX ';
        } else {
            $rows[8] .= '     ';
        }

        if ($pos != array_key_last($digits)) {
            $rows = array_map(fn (string $row) => $row .= '   ', $rows);
        }
    }

    foreach ($rows as $row) {
        echo $row . PHP_EOL;
    }

    echo PHP_EOL;
}

function sortString(string $string) : string {
    $chars = str_split($string);
    sort($chars);
    return implode($chars);
}

function generatePermutations(array $elements) : array {
    if (1 === count($elements)) {
        return $elements;
    }
    $result = [];
    foreach ($elements as $key => $item) {
        foreach (generatePermutations(array_diff_key($elements, [$key => $item])) as $p) {
            $result[] = $item . $p;
        }
    }
    return $result;
}