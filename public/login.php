<?php

require '../ApiClient.php';

session_start();

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

if ($login && $password) {
    $response = (new ApiClient())->getToken($login, $password);
    $token = $response['access_token'] ?? null;
    $errors = $response['errors'] ?? null;

    if ($token) {
        $_SESSION['access_token'] = $token;
        $_SESSION['username'] = $login;

        header('Location: /');
        exit;
    }
}

$error_class = isset($response['errors']) ? 'error' : '';

require('../templates/login.php');
