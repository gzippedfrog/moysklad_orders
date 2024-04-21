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

curl_setopt($ch, CURLOPT_URL, 'https://api.moysklad.ru/api/remap/1.2/entity/customerorder?order=moment,desc&limit=100&expand=agent,state,rate.currency');
$response = json_decode(curl_exec($ch), true);
$orders = $response['rows'] ?? [];

curl_setopt($ch, CURLOPT_URL, 'https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata');
$response = json_decode(curl_exec($ch), true);
$states = $response['states'] ?? [];

function decToHex($color)
{
    return '#' . str_pad(dechex($color), 6, '0', STR_PAD_LEFT);
}

require('../templates/orders.php');
