<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<?php
if (isset($data['deletedExchangeName']) && isset($data['exchangeDeleteSuccess'])) :
    if ($data['exchangeDeleteSuccess']) : ?>

        <h2>Successfully deleted exchange <?= $data['deletedExchangeName'] ?></h2>

    <?php else : ?>

        <h2>Could not delete exchange <?= $data['deletedExchangeName'] ?></h2>

<?php
    endif;
endif; ?>

<?php
if (isset($data['addedExchangeName'])) : ?>
    <h2>Added exchange <?= $data['addedExchangeName'] ?></h2>

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
    <input type="text" name="exchangename" placeholder="Exchange name" required>
    <input type="submit" value="Add">

</form>