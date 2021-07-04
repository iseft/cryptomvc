<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<?php
if (isset($data['deletedCoinName']) && isset($data['coinDeleteSuccess'])) :
    if ($data['coinDeleteSuccess']) : ?>

        <h2>Successfully deleted coin <?= $data['deletedCoinName'] ?></h2>

    <?php else : ?>

        <h2>Could not delete coin <?= $data['deletedCoinName'] ?></h2>

<?php
    endif;
endif; ?>

<?php
if (isset($data['addedCoinName'])) : ?>
    <h2>Added coin <?= $data['addedCoinName'] ?> (<?= $data['addedCoinSymbol'] ?>)</h2>

<?php endif; ?>


<table>
    <tr>
        <th>Coin name</th>
        <th>Coin symbol</th>
        <th>API ID</th>
        <th>Latest price</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php

    foreach ($data['coins'] as $row) : ?>

        <tr>
            <td><?= $row->name ?></td>
            <td><?= $row->symbol ?></td>
            <td><?= $row->api_id ?></td>
            <td><?= $row->latestprice ?></td>
            <td><a href="http://<?php echo URLROOT; ?>/coins/edit/<?= $row->id ?>">Edit</a></td>
            <td><a href="http://<?php echo URLROOT; ?>/coins/delete/<?= $row->id ?>" class="confirmDelete">Delete</a></td>
        </tr>

    <?php endforeach; ?>
</table>

<form action="http://<?php echo URLROOT?>/coins/add" method="POST">
<label for="coinname">Coin: </label>
<input type="text" name="coinname" id="coinname" placeholder="Coin name" required>
<label for="coinsymbol">Symbol: </label>
<input type="text" name="coinsymbol" id="coinsymbol" placeholder="Coin symbol" required>
<label for="apiID">Symbol: </label>
<input type="text" name="apiID" id="apiID" placeholder="API ID" required>
<input type="submit" value="Add">

</form>