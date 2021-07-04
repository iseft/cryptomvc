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

        <p class="successFeedback">Successfully deleted exchange <?= $data['deletedExchangeName'] ?></p>

    <?php else : ?>

        <p class="invalidFeedback">Could not delete exchange <?= $data['deletedExchangeName'] ?></p>

<?php
    endif;
endif; ?>

<?php
if (isset($data['addedExchangeName'])) : ?>
    <p class="successFeedback">Added exchange <?= $data['addedExchangeName'] ?></p>

<?php endif; ?>


<table>
    <tr>
        <th>Exchange name</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php

    foreach ($data['exchanges'] as $row) : ?>

        <tr>
            <td><?= $row->name ?></td>
            <td> <a href="http://<?php echo URLROOT; ?>/exchanges/edit/<?= $row->id ?>">Edit</a></td>
            <td> <a href="http://<?php echo URLROOT; ?>/exchanges/delete/<?= $row->id ?>" class="confirmDelete">Delete</a></td>
        </tr>

    <?php endforeach; ?>
</table>


<form action="http://<?php echo URLROOT ?>/exchanges/add" method="POST">
    <input type="text" name="exchangename" placeholder="Exchange name" class="textInput" required>
    <input type="submit" id="submit" value="Add">

</form>

</div>