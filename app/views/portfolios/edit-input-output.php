<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<?php if (isset($data["updated"])) :?>
<h2>Updated</h2>
<?php endif; ?>

<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
<h2>User: <?= $data['inputOutputUser'] ?></h2>
<?php endif; ?>

<form action="http://<?php echo URLROOT ?>/portfolios/edit_input_output/<?=$data['inputOutput']->id ?>" method="POST">
<input type="hidden" name="iosID" value="<?=$data['inputOutput']->id ?>">
<input type="hidden" name="userID" value="<?=$_SESSION['user_id'] ?>">

<label for="date">Date: </label>
<input type="date" name="date" id="date" value="<?=$data['inputOutput']->date ?>">

<label for="coinValue">Amount: </label>
<input type="text" name="amount" id="amount" value="<?=$data['inputOutput']->amount ?>">

<label for="exchange">Exchange: </label>
<select name="exchangeID" id="excahnge">
        <?php foreach ($data['allExchanges'] as $row) : ?>

            <option value="<?= $row->id; ?>" <?php echo ($row->id == $data['inputOutput']->exchange_id) ? 'selected' : '' ?>><?= $row->name; ?></option>

        <?php endforeach; ?>
    </select>

<input type="submit" value="Submit">
</form>