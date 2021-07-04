<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<?php
if (isset($data['iosDeleteSuccess'])) :
    if ($data['iosDeleteSuccess']) : ?>

        <h2>Successfully deleted deposit/withdrawal.</h2>

    <?php else : ?>

        <h2>Could not delete deposit/withdrawal.</h2>

<?php
    endif;
endif; ?>

<?php
if (isset($data['iosAddSuccess'])) : ?>
    <h2>Successfully added new deposit/withdrawal.</h2>

<?php endif; ?>



<?php foreach ($data['allInputsOutputs'] as $key => $value) : ?>

    <h2><?= $key ?></h2>

    <h3>Sum value: <?= $data['inputsOutputs'][$key] ?></h3>

    <table>
        <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Exchange</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        <?php

        foreach ($data['allInputsOutputs'][$key] as $inputOutput) : ?>

            <tr>
                <th><?= $inputOutput['date'] ?></th>
                <th><?= $inputOutput['amount'] ?></th>
                <th><?= $inputOutput['exchangeName'] ?></th>
                <td><a href="http://<?php echo URLROOT; ?>/portfolios/edit_input_output/<?= $inputOutput['id'] ?>">Edit</a></td>
                <td><a href="http://<?php echo URLROOT; ?>/portfolios/delete_input_output/<?= $inputOutput['id'] ?>" class="confirmDelete">Delete</a></td>
            </tr>

        <?php endforeach; ?>
    </table>

    <form action="http://<?php echo URLROOT; ?>/portfolios/addInputOutput" method="POST">
        <input type="hidden" name="user_id" value="<?= $data['userNamesAndIDs'][$key] ?>">

        <label for="date">Date: </label>
        <input type="date" name="date" id="date" required>

        <label for="amount">Amount (USD): </label>
        <input type="number" name="amount" id="amount" required>

        <label for="exchange">Exchange: </label>
        <select name="exchange_id" id="exchange">
            <?php foreach ($data['exchanges'] as $row) : ?>

                <option value="<?= $row->id; ?>"><?= $row->name; ?></option>

            <?php endforeach; ?>
        </select>

        <input type="submit" value="Add">

    </form>

<?php endforeach; ?>