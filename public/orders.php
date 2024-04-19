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

//$ch = curl_init();
//curl_setopt_array($ch, $curl_opts);

//curl_setopt($ch, CURLOPT_URL, 'https://api.moysklad.ru/api/remap/1.2/entity/customerorder');
//$response = json_decode(curl_exec($ch), true);
//$orders = $response['rows'] ?? [];
//
//curl_setopt($ch, CURLOPT_URL, 'https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata');
//$response = json_decode(curl_exec($ch), true);
//$states = $response['states'] ?? [];

$orders = json_decode(file_get_contents('orders.json'), true);
$states = json_decode(file_get_contents('states.json'), true);

foreach ($states as $i => $state) {
    $states[$i]['hexColor'] = '#' . str_pad(dechex($state['color']), 6, '0', STR_PAD_LEFT);
}

$states = array_combine(array_map(fn($s) => $s['meta']['href'], $states), $states);

usort($orders, fn($a, $b) => strtotime($b['moment']) - strtotime($a['moment']));

//foreach ($orders as $i => $order) {
//    curl_setopt($ch, CURLOPT_URL, $order['agent']['meta']['href']);
//    $orders[$i]['agent'] = json_decode(curl_exec($ch), true);
//}

//file_put_contents('orders.json', json_encode($orders, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
//file_put_contents('states.json', json_encode($states, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

//header('Content-Type: application/json');
//echo json_encode($orders);
//exit;

//echo '<pre>';
//var_export($orders);
//echo '</pre>';

//header('Content-Type: application/json');
//echo $response;
//var_export(json_validate($response));

//exit;

//var_export($_SESSION);

require('../templates/orders.php');
