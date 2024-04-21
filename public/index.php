<?php

session_start();

if (!isset($_SESSION['access_token'])) {
    header('Location: login.php');
    exit;
}

$errors = [];

$curl_opts = [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $_SESSION['access_token'],
        'Accept-Encoding: gzip',
    ],
    CURLOPT_ENCODING => 'gzip',
];

$ch = curl_init();
curl_setopt_array($ch, $curl_opts);

curl_setopt($ch, CURLOPT_URL, 'https://api.moysklad.ru/api/remap/1.2/entity/customerorder?order=moment,desc&limit=100&expand=agent,state');
$response = json_decode(curl_exec($ch), true);
$orders = $response['rows'] ?? [];

//header('Content-Type: application/json');
//echo json_encode($orders[0]['state']);
//exit;

curl_setopt($ch, CURLOPT_URL, 'https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata');
$response = json_decode(curl_exec($ch), true);
$states = $response['states'] ?? [];

//$states = array_combine(array_map(fn($s) => $s['meta']['href'], $states), $states);

//file_put_contents('../orders.json', json_encode($orders, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
//file_put_contents('../states.json', json_encode($states, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

//$orders = json_decode(file_get_contents('../orders.json'), true);
//$states = json_decode(file_get_contents('../states.json'), true);

function decToHex($color)
{
    return '#' . str_pad(dechex($color), 6, '0', STR_PAD_LEFT);
}

require('../templates/orders.php');
