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

                    <div class="state-select">
                        <?php foreach ($states as $state): ?>
                            <div class="state-select__option"
                                 data-id="<?= $state['id'] ?>"
                                 data-order-id="<?= $order['id'] ?>">
                                                    <span class="state-select__color-indicator"
                                                          style="background: <?= $state['hexColor'] ?>"></span>
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
        let select = $(this).children(".state-select");
        let newState = (select.css("display") === "none") ? "inline-block" : "none";
        select.css("display", newState);
    });

    fetch(
        "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/30378daa-fcc3-11ee-0a80-0b56001635b6",
        {
            method: "PUT",
            headers: {
                "Authorization": "Basic YWRtaW5AZG1pdHJ5dHNlcGFldjo2R2Jyb2VLWWl1blZRSA==",
                "Accept-Encoding": "gzip",
                "Content-Type": "application/json"
            },
            // mode: "no-cors", // no-cors, *cors, same-origin
            credentials: "include", // include, *same-origin, omit
            body: JSON.stringify({
                'name': Date.now()
            })
        }
    ).then(console.log);

    $('.state-select__option').on("click", async function () {
        console.log("click");
        const stateId = $(this).data('id');
        const orderId = $(this).data('order-id');

    });
</script>

<?php require('footer.php'); ?>
