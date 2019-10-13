<?php declare(strict_types=1);

$expected = trim(json_encode([
    'Underscore: :foo, :bar' => 'test',
    'Lang: :foo, :bar' => '',
    'Welcome, :name' => '',
    'Trip to :planet, check-in opens :time' => '',
    'Check offers to :planet' => '',
], JSON_PRETTY_PRINT));

$actual = trim(file_get_contents("resources/lang/pt-br.json"));

if ($expected !== $actual) {
    throw new Exception("Keys scanned does not match");
}

echo 'Integration works :)';
