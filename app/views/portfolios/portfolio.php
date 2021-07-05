<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">

    <h2>Portfolio</h2>

    <form action="http://<?php echo URLROOT ?>/coins/updatePrice" method="POST">
        <input type="submit" id="submit" value="Update Prices!">
    </form>

    <?php foreach ($data['coinSumValues'] as $key => $coinSumValues) : ?>

        <h3 class="listview"><?= $key ?> (Total value: $<?= $data['totalUSDValue'][$key] ?>)</h3>

        <table>
            <tr>
                <th>Coin name</th>
                <th>Coin #</th>
                <th>Coin price (USD)</th>
                <th>Total value (USD)</th>
            </tr>
            <?php

            foreach ($coinSumValues as $key => $value) : ?>

                <tr>
                    <td><?= $key ?></td>
                    <td><?= $value['sum'] ?></td>
                    <td><?= $value['price'] ?></td>
                    <td><?= $value['totalValue'] ?></td>
                </tr>

            <?php endforeach; ?>
        </table>

    <?php endforeach; ?>
</div>