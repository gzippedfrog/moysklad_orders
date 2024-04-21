<?php
require('head.php'); ?>

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
        <tr data-order-id="<?= $order['id'] ?>">
            <td><a href="<?= $order['meta']['uuidHref'] ?>" target="_blank"><?= $order['name'] ?></a></td>
            <td><?= date('d.m.Y H:i', strtotime($order['moment'])) ?></td>
            <td>
                <a href="<?= $order['agent']['meta']['uuidHref'] ?>" target="_blank"><?= $order['agent']['name'] ?></a>
            </td>
            <td style="text-align: right"><?= number_format($order['sum'] / 100, 2, ',', ' ') ?></td>
            <td><?= $order['rate']['currency']['name'] ?></td>
            <td>
                <span class="order-status"
                      style="background: <?= decToHex($order['state']['color']) ?>">
                    <?= $order['state']['name'] ?>

                    <div class="state-select">
                        <?php foreach ($states as $state): ?>
                            <div class="state-select__option" data-state-id="<?= $state['id'] ?>">
                                                    <span class="state-select__color-indicator"
                                                          style="background: <?= decToHex($state['color']) ?>"></span>
                                <?= $state['name'] ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </span>
            </td>
            <td><?= date('d.m.Y H:i', strtotime($order['updated'])) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
    $('.order-status').on("click", function () {
        const select = $(this).children(".state-select");
        const newState = (select.css("display") === "none") ? "inline-block" : "none";
        select.css("display", newState);
    });

    $('.state-select__option').on("click", function () {
        const orderId = $(this).closest('tr').data('order-id');
        const stateId = $(this).data('state-id');

        fetch(
            "update_order_status.php",
            {
                method: "PUT",
                body: JSON.stringify({orderId, stateId})
            }
        )
            .then(res => res.json())
            .then((data) => {
                if (data.success) {
                    window.location.reload();
                }
            });
    });
</script>

<?php require('footer.php'); ?>
