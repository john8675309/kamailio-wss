#!/usr/bin/php
<?php

// Grab CLI args
$to    = $argv[1] ?? '';
$from  = $argv[2] ?? '';
$name  = $argv[3] ?? '';
// Prepare payload
$name = str_replace('"', '', $name);
$name = rawurlencode($name);

$data = [
    'number' => $to,
    'from'   => $from,
    'name'   => $name,
];
//Your push notification script.
$ch = curl_init('https://x.x.x.x/call.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    file_put_contents('/tmp/call_hook.log', 'CURL ERROR: ' . curl_error($ch) . PHP_EOL, FILE_APPEND);
} else {
    file_put_contents('/tmp/call_hook.log', 'OK: ' . $response . PHP_EOL, FILE_APPEND);
}

curl_close($ch);
