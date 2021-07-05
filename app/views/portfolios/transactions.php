<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">

    <h2>Manage Transactions</h2>

    <?php
    if (isset($data['transactionDeleteSuccess'])) :
        if ($data['transactionDeleteSuccess']) : ?>

            <p class="successFeedback">Successfully deleted transaction.</p>

        <?php else : ?>

            <p class="invalidFeedback">Could not delete transaction.</p>

    <?php
        endif;
    endif; ?>

    <?php
    if (isset($data['transactionAddSuccess'])) : ?>
        <p class="successFeedback">Successfully added new transaction.</p>

    <?php endif; ?>


    <?php foreach ($data['transactions'] as $key => $value) : ?>

        <h3><?= $key ?></h3>

        <div class="wrapper-center">

        <table>
            <tr>
                <th>Coin name</th>
                <th>Date</th>
                <th>Coin value</th>
                <th>Coin #</th>
                <th>Exchange</th>
                <th class="edit">Edit</th>
                <th class="delete">Delete</th>
            </tr>

            <?php

            foreach ($data['transactions'][$key] as $transaction) : ?>

                <tr>
                    <td><?= $transaction['date'] ?></th>
                    <td><?= $transaction['coinValue'] ?></th>
                    <td><?= $transaction['coinName'] ?></th>
                    <td><?= $transaction['coinNum'] ?></th>
                    <td><?= $transaction['exchangeName'] ?></th>
                    <td class="edit"><a href="http://<?php echo URLROOT; ?>/portfolios/edit_transaction/<?= $transaction['id'] ?>">Edit</a></td>
                    <td class="delete"><a href="http://<?php echo URLROOT; ?>/portfolios/delete_transaction/<?= $transaction['id'] ?>" class="confirmDelete">Delete</a></td>
                </tr>

            <?php endforeach; ?>

        </table>

        <h4 class="add">Add new transaction: </h4>

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

            <input type="number" name="coinvalue" id="coinvalue" value="Coin value" step="0.00000001" required>

            <label for="coinnum">Coin #:</label>
            <input type="number" name="coinnum" id="coinnum" value="Number of coins" step="0.00000001" required>


            <label for="exchange">Exchange: </label>
            <select name="exchange_id" id="exchange">
                <?php foreach ($data['exchanges'] as $row) : ?>

                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>

                <?php endforeach; ?>
            </select>

            <input type="submit" id="submit" value="Add">

        </form>

        </div>

    <?php endforeach; ?>

</div>