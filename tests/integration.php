<?php declare(strict_types=1);

/**
 |--------------------------------------------------------------------------
 | Integration test
 |--------------------------------------------------------------------------
 | This test will be used by travis to check if installation and scan work properly (see .travis.yml)
 */
$expected = trim(json_encode([
    'Underscore: :foo, :bar' => '',
    'Lang: :foo, :bar' => '',
    'Welcome, :name' => '',
    'Trip to :planet, check-in opens :time' => '',
    'Check offers to :planet' => '',
], JSON_PRETTY_PRINT));

$received = trim(file_get_contents("resources/lang/pt-br.json"));

if ($expected !== $received) {
    throw new Exception(sprintf("Keys scanned does not match, expected: %s, received: %s", $expected, $received));
}

echo 'Integration works :)';
