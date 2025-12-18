<?php

$test = 'ModaCrochê';
$normalized = iconv('UTF-8', 'ASCII//TRANSLIT', trim($test));
$lower = strtolower($normalized);

echo "Original: {$test}\n";
echo "Normalizado: {$normalized}\n";
echo "Lowercase: {$lower}\n";
echo "Bytes: " . bin2hex($lower) . "\n";
