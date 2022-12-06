<?php

const MARKER_LENGHT = 14;

$input = trim(file_get_contents(__DIR__ . '/input.txt'));

$buffer = [];
for ($i = MARKER_LENGHT; $i < strlen($input); $i++) {
    if (count(array_unique(str_split(substr($input, $i - MARKER_LENGHT, MARKER_LENGHT)))) === MARKER_LENGHT) {
        printf("Marker occurred after %d chars\n", $i);
        die();
    }
}