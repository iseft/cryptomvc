<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">

<h2>Edit transaction details</h2>

    <?php if (isset($data["updated"])) : ?>
        <p class="successFeedback">Updated transaction details</p>
    <?php endif; ?>

    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
        <h3>User: <?= $data['transactionUser'] ?></h3>
    <?php endif; ?>

    <form action="http://<?php echo URLROOT ?>/portfolios/edit_transaction/<?= $data['transaction']->id ?>" method="POST">
        <input type="hidden" name="transactionID" value="<?= $data['transaction']->id ?>">
        <input type="hidden" name="userID" value="<?= $_SESSION['user_id'] ?>">

        <label for="coin">Coin: </label>
        <select name="coinID" id="coin">
            <?php foreach ($data['allCoins'] as $row) : ?>

                <option value="<?= $row->id; ?>" <?php echo ($row->id == $data['transaction']->coin_id) ? 'selected' : '' ?>><?= $row->name; ?></option>

            <?php endforeach; ?>
        </select>
        <label for="date">Date: </label>
        <input type="date" name="date" id="date" value="<?= $data['transaction']->date ?>">

        <label for="coinValue">Coin value: </label>
        <input type="number" step="0.00000001" name="coinValue" id="coinValue" value="<?= $data['transaction']->coinvalue ?>">

        <label for="coinNum">Coin #: </label>
        <input type="number" step="0.00000001" name="coinNum" id="coinNum" value="<?= $data['transaction']->coinnum ?>">

        <label for="exchange">Exchange: </label>
        <select name="exchangeID" id="excahnge">
            <?php foreach ($data['allExchanges'] as $row) : ?>

                <option value="<?= $row->id; ?>" <?php echo ($row->id == $data['transaction']->exchange_id) ? 'selected' : '' ?>><?= $row->name; ?></option>

            <?php endforeach; ?>
        </select>

        <input type="submit" id="submit" value="Submit">
    </form>

    <p class="back"><i class="fas fa-backward back"></i> <a href="http://<?php echo URLROOT; ?>/portfolios/transactions">Back to Transactions</a></p>

</div>