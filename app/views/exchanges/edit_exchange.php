<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<?php if (isset($data["updated"])) :?>
<h2>Updated</h2>
<?php endif; ?>

<form action="http://<?php echo URLROOT ?>/exchanges/edit/<?=$data['exchange']->id ?>" method="POST">
<input type="hidden" name="exchangeID" value="<?=$data['exchange']->id ?>">
<label for="exchangeName">Edit name: </label>
<input type="text" name="exchangeName" id="exchangeName" value="<?=$data['exchange']->name ?>">
<input type="submit" value="Submit">
</form>