<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<?php
if (isset($data['transactionDeleteSuccess'])) :
    if ($data['transactionDeleteSuccess']) : ?>

        <h2>Successfully deleted transaction.</h2>

    <?php else : ?>

        <h2>Could not delete transaction.</h2>

<?php
    endif;
endif; ?>

<?php
if (isset($data['transactionAddSuccess'])) : ?>
    <h2>Successfully added new transaction.</h2>

<?php endif; ?>


<?php foreach ($data['transactions'] as $key => $value) : ?>

    <h2><?= $key ?></h2>

    <table>
        <tr>
            <th>Coin name</th>
            <th>Date</th>
            <th>Coin value</th>
            <th>Coin #</th>
            <th>Exchange</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        <?php

        foreach ($data['transactions'][$key] as $transaction) : ?>

            <tr>
                <th><?= $transaction['coinName'] ?></th>
                <th><?= $transaction['date'] ?></th>
                <th><?= $transaction['coinValue'] ?></th>
                <th><?= $transaction['coinNum'] ?></th>
                <th><?= $transaction['exchangeName'] ?></th>
                <td><a href="http://<?php echo URLROOT; ?>/portfolios/edit_transaction/<?= $transaction['id'] ?>">Edit</a></td>
                <td><a href="http://<?php echo URLROOT; ?>/portfolios/delete_transaction/<?= $transaction['id'] ?>">Delete</a></td>
            </tr>

        <?php endforeach; ?>

    </table>

    <form action="http://<?php echo URLROOT; ?>/portfolios/addTransaction" method="POST">
        <input type="hidden" name="user_id" value="<?= $data['userNamesAndIDs'][$key] ?>">

        <label for="coin">Coin: </label>

        <select name="coin_id" id="coin">
            <?php foreach ($data['coins'] as $row) : ?>

                <option value="<?= $row->id; ?>"><?= $row->name; ?></option>

            <?php endforeach; ?>
        </select>

        <label for="date">Date: </label>
        <input type="date" name="date" id="date" required>

        <label for="coinvalue">Coin value: </label>

        <input type="number" name="coinvalue" id="coinvalue" value="Coin value" required>

        <label for="coinnum">Coin #:</label>
        <input type="number" name="coinnum" id="coinnum" value="Number of coins" required>


        <label for="exchange">Exchange: </label>
        <select name="exchange_id" id="exchange">
            <?php foreach ($data['exchanges'] as $row) : ?>

                <option value="<?= $row->id; ?>"><?= $row->name; ?></option>

            <?php endforeach; ?>
        </select>

        <input type="submit" value="Add">

    </form>

<?php endforeach; ?>