<?php

session_start();

if (!isset($_SESSION['access_token'])) {
    header('Location: login.php');
    exit;
}

$params = json_decode(file_get_contents('php://input'), true);

$state_id = $params['stateId'];
$order_id = $params['orderId'];

$curl_opts = [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $_SESSION['access_token'],
        'Accept-Encoding: gzip',
        'Content-Type: application/json'
    ],
    CURLOPT_ENCODING => 'gzip',
];

$ch = curl_init();
curl_setopt_array($ch, $curl_opts);

curl_setopt($ch, CURLOPT_URL, 'https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/');
$response = json_decode(curl_exec($ch), true);
$states = $response['states'] ?? [];

$states = array_filter($states, fn($state) => $state['id'] == $state_id);
$new_state = array_values($states)[0] ?? null;
$url = 'https://api.moysklad.ru/api/remap/1.2/entity/customerorder/' . $order_id;

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => json_encode([
        'state' => ['meta' => $new_state['meta']]
    ])
]);
$response = json_decode(curl_exec($ch), true);

echo json_encode(['success' => true]);