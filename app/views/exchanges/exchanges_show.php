<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">

    <h1>Manage Exchanges</h1>

    <?php
    if (isset($data['deletedExchangeName']) && isset($data['exchangeDeleteSuccess'])) :
        if ($data['exchangeDeleteSuccess']) : ?>

            <p class="successFeedback">Successfully deleted exchange: <?= $data['deletedExchangeName'] ?></p>

        <?php else : ?>

            <p class="invalidFeedback">Could not delete exchange: <?= $data['deletedExchangeName'] ?></p>

    <?php
        endif;
    endif; ?>

    <?php
    if (isset($data['addedExchangeName'])) : ?>
        <p class="successFeedback">Added exchange: <?= $data['addedExchangeName'] ?></p>

    <?php endif; ?>

    <div class="wrapper-center">

        <table>
            <tr>
                <th>Exchange name</th>
                <th class="edit">Edit</th>
                <th class="delete">Delete</th>
            </tr>
            <?php

            foreach ($data['exchanges'] as $row) : ?>

                <tr>
                    <td><?= $row->name ?></td>
                    <td class="edit"> <a href="https://<?php echo URLROOT; ?>/exchanges/edit/<?= $row->id ?>"><i class="fas fa-edit"></i></a></td>
                    <td class="delete"> <a href="https://<?php echo URLROOT; ?>/exchanges/delete/<?= $row->id ?>" class="confirmDelete"><i class="fas fa-trash-alt"></i></a></td>
                </tr>

            <?php endforeach; ?>
        </table>



        <h4 class="add">Add new exchange: </h4>

        <form action="https://<?php echo URLROOT ?>/exchanges/add" method="POST">
            <label for="exchangename">Exchange name: </label>
            <input type="text" name="exchangename" id="exchangename" placeholder="Exchange name" class="textInput" required>
            <input type="submit" id="submit" value="Add">

        </form>

    </div>
</div>