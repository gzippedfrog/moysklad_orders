<?php require('../templates/head.php'); ?>

<div class="logout-form-container">
    <div><?= $_SESSION['username'] ?></div>
    <div class="logout-form">
        <form action="logout.php" method="POST">
            <button type="submit" class="button logout-form__button">Выйти</button>
        </form>
    </div>
</div>

<?php foreach ($errors as $error): ?>
    <p class="error"><?= $error['error'] ?></p>
<?php endforeach; ?>

<div>
    <?php foreach ($states as $state): ?>
        <div style="">
            <?= $state['name'] ?>
        </div>
    <?php endforeach; ?>
</div>

<table class="ui-table">
    <thead>
    <tr>
        <th>№</th>
        <th>Время</th>
        <th>Контрагент</th>
        <th style="text-align: right">Сумма</th>
        <th>Валюта</th>
        <th>Статус</th>
        <th>Когда изменен</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><a href="<?= $order['meta']['uuidHref'] ?>" target="_blank"><?= $order['name'] ?></a></td>
            <td><?= date('d.m.Y H:i', strtotime($order['moment'])) ?></td>
            <td>
                <a href="<?= $order['agent']['meta']['uuidHref'] ?>" target="_blank"><?= $order['agent']['name'] ?></a>
            </td>
            <td style="text-align: right"><?= number_format($order['sum'] / 100, 2, ',', ' ') ?></td>
            <td>руб</td>
            <td>
                <span class="order-status"
                      style="background: <?= $states[$order['state']['meta']['href']]['hexColor'] ?>">
                    <?= $states[$order['state']['meta']['href']]['name'] ?>
                </span>
            </td>
            <td><?= date('d.m.Y H:i', strtotime($order['updated'])) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require('../templates/footer.php'); ?>
