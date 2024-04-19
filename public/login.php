<?php

session_start();

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

if ($login && $password) {
    $ch = curl_init('https://api.moysklad.ru/api/remap/1.2/security/token');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Basic '.base64_encode($login.':'.$password),
            'Accept-Encoding: gzip',
        ],
        CURLOPT_POST           => true,
        CURLOPT_ENCODING       => 'gzip',
    ]);
    $response = json_decode(curl_exec($ch), true);

    if (array_key_exists('access_token', $response)) {
        $_SESSION['access_token'] = $response['access_token'];
        $_SESSION['username'] = $login;
        header('Location: orders.php');
        exit;
    }
}

$error_class = isset($response['errors']) ? 'error' : '';

?>

<?php require('../templates/head.php'); ?>

<div class="login-form-container">
    <form class="login-form" method="POST">
        <label class="h3 login-form__label <?= $error_class ?>" for="login">Логин:</label>
        <input class="ui-input login-form__input <?= $error_class ?>" type="text" id="login" name="login"
               value="admin@dmitrytsepaev">

        <label class="h3 login-form__label <?= $error_class ?>" for="password">Пароль:</label>
        <input
                class="ui-input login-form__input <?= $error_class ?>"
                type="password" id="password" name="password"
                value="6GbroeKYiunVQH">

        <?php if (isset($response['errors'])): ?>
            <?php foreach ($response['errors'] as $error): ?>
                <p class="error"><?= $error['error'] ?></p>
            <?php endforeach ?>
        <?php endif ?>

        <button type="submit" class="button button--success login-form__submit">Авторизоваться</button>
    </form>
</div>

<?php require('../templates/footer.php'); ?>
