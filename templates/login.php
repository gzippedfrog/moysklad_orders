<?php
require('head.php');
/** @var string $login */
/** @var string $password */
/** @var string $error_class */
?>

    <div class="login-form-container">
        <form class="login-form" method="POST">
            <label class="h3 login-form__label <?= $error_class ?>" for="login">Логин:</label>
            <input class="ui-input login-form__input <?= $error_class ?>" type="text" id="login" name="login"
                   value="<?= $login ?>" required>

            <label class="h3 login-form__label <?= $error_class ?>" for="password">Пароль:</label>
            <input
                    class="ui-input login-form__input <?= $error_class ?>"
                    type="password" id="password" name="password"
                    value="<?= $password ?>" required>

            <?php if (isset($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <p class="error"><?= $error['error'] ?></p>
                <?php endforeach ?>
            <?php endif ?>

            <button type="submit" class="button button--success login-form__submit">Авторизоваться</button>
        </form>
    </div>

<?php require('footer.php'); ?>