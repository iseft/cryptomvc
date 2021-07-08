<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">

    <h1>Manage Coins</h1>

    <?php
    if (isset($data['deletedCoinName']) && isset($data['coinDeleteSuccess'])) :
        if ($data['coinDeleteSuccess']) : ?>

            <p class="successFeedback">Successfully deleted coin: <?= $data['deletedCoinName'] ?></p>

        <?php else : ?>

            <p class="invalidFeedback">Could not delete coin: <?= $data['deletedCoinName'] ?></p>

        <?php
        endif;
    endif; ?>

        <?php
        if (isset($data['addedCoinName'])) : ?>
            <p class="successFeedback">Added coin: <?= $data['addedCoinName'] ?> (<?= $data['addedCoinSymbol'] ?>)</p>

        <?php endif; ?>


        <div class="wrapper-center">
            <table>
                <tr>
                    <th>Coin name</th>
                    <th>Coin symbol</th>
                    <th>API ID</th>
                    <th>Latest price</th>
                    <th class="edit">Edit</th>
                    <th class="delete">Delete</th>
                </tr>
                <?php

                foreach ($data['coins'] as $row) : ?>

                    <tr>
                        <td><?= $row->name ?></td>
                        <td><?= $row->symbol ?></td>
                        <td><?= $row->api_id ?></td>
                        <td><?= $row->latestprice ?></td>
                        <td class="edit"><a href="https://<?php echo URLROOT; ?>/coins/edit/<?= $row->id ?>"><i class="fas fa-edit"></i></a></td>
                        <td class="delete"><a href="https://<?php echo URLROOT; ?>/coins/delete/<?= $row->id ?>" class="confirmDelete"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>

                <?php endforeach; ?>
            </table>

            <h4 class="add">Add new coin: </h4>

            <form action="https://<?php echo URLROOT ?>/coins/add" method="POST">
                <label for="coinname">Coin: </label>
                <input type="text" name="coinname" id="coinname" placeholder="Coin name" required>
                <label for="coinsymbol">Symbol: </label>
                <input type="text" name="coinsymbol" id="coinsymbol" placeholder="Coin symbol" required>
                <label for="apiID">API (CoinGecko): </label>
                <input type="text" name="apiID" id="apiID" placeholder="API ID" required>
                <input type="submit" id="submit" value="Add">

            </form>

        </div>
</div>