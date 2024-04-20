<?php

session_start();

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

if ($login && $password) {
    $ch = curl_init('https://api.moysklad.ru/api/remap/1.2/security/token');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Basic ' . base64_encode($login . ':' . $password),
            'Accept-Encoding: gzip',
        ],
        CURLOPT_POST => true,
        CURLOPT_ENCODING => 'gzip',
    ]);
    $response = json_decode(curl_exec($ch), true);

    if (array_key_exists('access_token', $response)) {
        $_SESSION['access_token'] = $response['access_token'];
        $_SESSION['username'] = $login;
        header('Location: /');
        exit;
    }
}

$error_class = isset($response['errors']) ? 'error' : '';

require('../templates/login.php');
