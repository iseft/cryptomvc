<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">

    <h2>Manage Deposits/Withdrawals</h2>

    <?php
    if (isset($data['iosDeleteSuccess'])) :
        if ($data['iosDeleteSuccess']) : ?>

            <p class="successFeedback">Successfully deleted deposit/withdrawal.</p>

        <?php else : ?>

            <p class="invalidFeedback">Could not delete deposit/withdrawal.</p>

    <?php
        endif;
    endif; ?>

    <?php
    if (isset($data['iosAddSuccess'])) : ?>
        <p class="successFeedback">Successfully added new deposit/withdrawal.</p>

    <?php endif; ?>



    <?php foreach ($data['allInputsOutputs'] as $key => $value) : ?>

        <h3 class="listview"><?= $key ?> (Total: $<?= $data['inputsOutputs'][$key] ?>)</h3>

        <div class="wrapper-center">

            <table>
                <tr>
                    <th>Date</th>
                    <th>Amount (USD)</th>
                    <th>Exchange</th>
                    <th class="edit">Edit</th>
                    <th class="delete">Delete</th>
                </tr>

                <?php

                foreach ($data['allInputsOutputs'][$key] as $inputOutput) : ?>

                    <tr>
                        <td><?= $inputOutput['date'] ?></th>
                        <td><?= $inputOutput['amount'] ?></th>
                        <td><?= $inputOutput['exchangeName'] ?></th>
                        <td class="edit"><a href="http://<?php echo URLROOT; ?>/portfolios/edit_input_output/<?= $inputOutput['id'] ?>"><i class="fas fa-edit"></i></a></td>
                        <td class="delete"><a href="http://<?php echo URLROOT; ?>/portfolios/delete_input_output/<?= $inputOutput['id'] ?>" class="confirmDelete"><i class="fas fa-trash-alt"></a></td>
                    </tr>

                <?php endforeach; ?>
            </table>

            <h4 class="add">Add new deposit/withdrawal: </h4>

            <form action="http://<?php echo URLROOT; ?>/portfolios/addInputOutput" method="POST">
                <input type="hidden" name="user_id" value="<?= $data['userNamesAndIDs'][$key] ?>">

                <label for="date">Date: </label>
                <input type="date" name="date" id="date" required>

                <label for="amount">Amount (USD): </label>
                <input type="number" name="amount" id="amount" step="0.000000001" required>

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