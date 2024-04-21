<?php

require '../ApiClient.php';

session_start();

$token = $_SESSION['access_token'] ?? null;

if (!$token) {
    header('Location: login.php');
    exit;
}

$client = new ApiClient($token);

$orders = $client->getOrders();
$states = $client->getStates();

require('../templates/orders.php');
