<?php declare(strict_types=1);

/**
 * |--------------------------------------------------------------------------
 * | Integration test
 * |--------------------------------------------------------------------------
 * | This test will be used by travis to check if installation and scan work properly (see .travis.yml)
 */

$diff = array_diff(
    [
        'Underscore: :foo, :bar' => '',
        'Lang: :foo, :bar' => '',
        'Welcome, :name' => '',
        'Trip to :planet, check-in opens :time' => '',
        'Check offers to :planet' => '',
        'Translations should also work with double quotes.' => '',
        'Shouldn\'t escaped quotes within strings also be correctly added?' => '',
        'Same goes for "double quotes".' => '',
        'String using (parentheses).' => '',
        "Double quoted string using \"double quotes\", and C-style escape sequences.\n\t\\" => '',
    ],
    json_decode(file_get_contents("resources/lang/pt-br.json"), true)
);

if (!empty($diff)) {
    throw new Exception(
        sprintf("Keys scanned does not match by the diff:\n%s\n", print_r($diff, true))
    );
}

echo 'Integration works :)';
