<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">

<h2>Edit coin details</h2>

    <?php if (isset($data["updated"])) : ?>
        <p class="successFeedback">Coin updated.</p>
    <?php endif; ?>

    <form action="http://<?php echo URLROOT ?>/coins/edit/<?= $data['coin']->id ?>" method="POST">
        <input type="hidden" name="coinID" value="<?= $data['coin']->id ?>">
        <label for="coinName">Edit name: </label>
        <input type="text" name="coinName" id="coinName" value="<?= $data['coin']->name ?>">
        <label for="coinSymbol">Edit symbol: </label>
        <input type="text" name="coinSymbol" id="coinSymbol" value="<?= $data['coin']->symbol ?>">
        <label for="apiID">Edit symbol: </label>
        <input type="text" name="apiID" id="apiID" value="<?= $data['coin']->api_id ?>">
        <input type="submit" id="submit" value="Submit">
    </form>

    <p class="back"><i class="fas fa-backward back"></i> <a href="http://<?php echo URLROOT; ?>/coins/show">Back to Coins</a></p>

</div>