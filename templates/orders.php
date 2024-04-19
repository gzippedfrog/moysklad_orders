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

<select class="ui-select" name="ui-select">
    <option value="ООО «Ромашка»">ООО «Ромашка»</option>
    <option value="ООО «Ромашка 2»">ООО «Ромашка 2»</option>
</select>

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
    <?php
    foreach ($orders as $order): ?>
        <tr>
            <td><a href="#"><?= $order['name'] ?></a></td>
            <td><?= date('d.m.Y H:i', strtotime($order['moment'])) ?></td>
            <td><?= $order['agent']['name'] ?></td>
            <td style="text-align: right"><?= number_format($order['sum'] / 100, 2, ',', ' ') ?></td>
            <td>руб</td>
            <td>
                <select class="" name="">
                    <option class="" style="background: <?= $order['state']['hexcolor'] ?>">
                        <?= $order['state']['name'] ?>
                    </option>
                </select>
            </td>
            <td><?= date('d.m.Y H:i', strtotime($order['updated'])) ?></td>
        </tr>
    <?php
    endforeach; ?>
    </tbody>
</table>

<?php require('../templates/footer.php'); ?>
