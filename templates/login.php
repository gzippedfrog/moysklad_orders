<?php require('head.php'); ?>

    <div class="login-form-container">
        <form class="login-form" method="POST">
            <label class="h3 login-form__label <?= $error_class ?>" for="login">Логин:</label>
            <input class="ui-input login-form__input <?= $error_class ?>" type="text" id="login" name="login"
                   value="<?= $login ?>">

            <label class="h3 login-form__label <?= $error_class ?>" for="password">Пароль:</label>
            <input
                    class="ui-input login-form__input <?= $error_class ?>"
                    type="password" id="password" name="password"
                    value="<?= $password ?>">

            <?php if (isset($response['errors'])): ?>
                <?php foreach ($response['errors'] as $error): ?>
                    <p class="error"><?= $error['error'] ?></p>
                <?php endforeach ?>
            <?php endif ?>

            <button type="submit" class="button button--success login-form__submit">Авторизоваться</button>
        </form>
    </div>

<?php require('footer.php'); ?>