<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<?php if (isset($data["updated"])) :?>
<h2>Updated</h2>
<?php endif; ?>

<form action="http://<?php echo URLROOT ?>/coins/edit/<?=$data['coin']->id ?>" method="POST">
<input type="hidden" name="coinID" value="<?=$data['coin']->id ?>">
<label for="coinName">Edit name: </label>
<input type="text" name="coinName" id="coinName" value="<?=$data['coin']->name ?>">
<label for="coinSymbol">Edit symbol: </label>
<input type="text" name="coinSymbol" id="coinSymbol" value="<?=$data['coin']->symbol ?>">
<input type="submit" value="Submit">
</form>