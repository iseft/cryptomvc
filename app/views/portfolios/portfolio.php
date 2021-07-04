<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<?php foreach ($data['coinSumValues'] as $key => $coinSumValues) : ?>

    <h2><?= $key ?></h2>

    <table>
        <tr>
            <th>Coin name</th>
            <th>Coin #</th>
            <th>Coin value</th>
            <th>Total value</th>
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

<form action="http://<?php echo URLROOT ?>/coins/updatePrice" method="POST">
<input type="submit" value="Update Prices!">
</form>