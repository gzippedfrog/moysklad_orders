<?php

require '../ApiClient.php';

session_start();

$token = $_SESSION['access_token'] ?? null;

if (!$token) {
    header('Location: login.php');
    exit;
}

$params = json_decode(file_get_contents('php://input'), true);

$stateId = $params['stateId'];
$orderId = $params['orderId'];

$client = new ApiClient($token);

$result = $client->updateOrderState($orderId, $stateId);

echo json_encode(['success' => isset($result['id'])]);

