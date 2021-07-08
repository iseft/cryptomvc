<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">

<h2>Edit deposit/withdrawal details</h2>

    <?php if (isset($data["updated"])) : ?>
        <p class="successFeedback">Deposit/withdrawal details updated.</p>
    <?php endif; ?>

    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
        <h3>User: <?= $data['inputOutputUser'] ?></h3>
    <?php endif; ?>

    <form action="https://<?php echo URLROOT ?>/portfolios/edit_input_output/<?= $data['inputOutput']->id ?>" method="POST">
        <input type="hidden" name="iosID" value="<?= $data['inputOutput']->id ?>">
        <input type="hidden" name="userID" value="<?= $_SESSION['user_id'] ?>">

        <label for="date">Date: </label>
        <input type="date" name="date" id="date" value="<?= $data['inputOutput']->date ?>">

        <label for="coinValue">Amount: </label>
        <input type="number" name="amount" id="amount" step="0.0000000001" value="<?= $data['inputOutput']->amount ?>">

        <label for="exchange">Exchange: </label>
        <select name="exchangeID" id="excahnge">
            <?php foreach ($data['allExchanges'] as $row) : ?>

                <option value="<?= $row->id; ?>" <?php echo ($row->id == $data['inputOutput']->exchange_id) ? 'selected' : '' ?>><?= $row->name; ?></option>

            <?php endforeach; ?>
        </select>

        <input type="submit" id="submit" value="Submit">
    </form>

    <p class="back"><i class="fas fa-backward back"></i> <a href="https://<?php echo URLROOT; ?>/portfolios/inputs_outputs">Back to deposits/withdrawals</a></p>

</div>