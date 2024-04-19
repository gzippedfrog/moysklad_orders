<?php

session_start();

if (!isset($_SESSION['access_token'])) {
    header('Location: login.php');
    exit;
}

$errors = [];

//$curl_opts = [
//    CURLOPT_RETURNTRANSFER => true,
//    CURLOPT_HTTPHEADER => [
//        'Authorization: Bearer ' . $_SESSION['access_token'],
//        'Accept-Encoding: gzip',
//    ],
//    CURLOPT_ENCODING => 'gzip',
//];

//$ch = curl_init('https://api.moysklad.ru/api/remap/1.2/entity/customerorder');
//curl_setopt_array($ch, $curl_opts);
//$response = json_decode(curl_exec($ch), true);
//
//$orders = $response['rows'] ?? [];
//
//usort($orders, fn($a, $b) => strtotime($b['moment']) - strtotime($a['moment']));
//
//foreach ($orders as $i => $order) {
//    curl_setopt($ch, CURLOPT_URL, $order['agent']['meta']['href']);
//    $orders[$i]['agent'] = json_decode(curl_exec($ch), true);
//
//    curl_setopt($ch, CURLOPT_URL, $order['state']['meta']['href']);
//    $orders[$i]['state'] = json_decode(curl_exec($ch), true);
//    $orders[$i]['state']['hexcolor'] = '#' . str_pad(dechex($orders[$i]['state']['color']), 6, '0', STR_PAD_LEFT);
//}

//file_put_contents('orders.json', json_encode($orders));

$orders = json_decode(file_get_contents('orders.json'), true);

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
