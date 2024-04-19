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

$ch1 = curl_init('https://api.moysklad.ru/api/remap/1.2/entity/customerorder');
$ch2 = curl_init('https://api.moysklad.ru/api/remap/1.2/entity/counterparty');

curl_setopt_array($ch1, $curl_opts);
curl_setopt_array($ch2, $curl_opts);

$mh = curl_multi_init();

curl_multi_add_handle($mh, $ch1);
curl_multi_add_handle($mh, $ch2);

$running = false;
do {
    curl_multi_exec($mh, $running);
} while ($running);

curl_multi_remove_handle($mh, $ch1);
curl_multi_remove_handle($mh, $ch2);
curl_multi_close($mh);

$response1 = json_decode(curl_multi_getcontent($ch1), true);
$response2 = json_decode(curl_multi_getcontent($ch2), true);

$orders = $response1['rows'] ?? [];
$agents = $response2['rows'] ?? [];

usort($orders, fn($a, $b) => strtotime($b['moment']) - strtotime($a['moment']));

if ($orders && $agents) {
    foreach ($orders as $i => $order) {
        $agent_id = explode('/', $order['agent']['meta']['href']);
        $agent_id = end($agent_id);

        foreach ($agents as $agent) {
            if ($agent['id'] === $agent_id) {
                $orders[$i]['agent'] = $agent;
                break;
            }
        }
    }
}


//header('Content-Type: application/json');
//echo json_encode($orders);
//exit;

//header('Content-Type: application/json');
//echo $response;
//var_export(json_validate($response));

//exit;

//var_export($_SESSION);

require('../templates/orders.php');
