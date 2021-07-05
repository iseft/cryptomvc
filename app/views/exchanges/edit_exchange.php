<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">

<h2>Edit exchange details</h2>

    <?php if (isset($data["updated"])) : ?>
        <p class="successFeedback">Exchange updated.</p>
    <?php endif; ?>

    <form action="http://<?php echo URLROOT ?>/exchanges/edit/<?= $data['exchange']->id ?>" method="POST">
        <input type="hidden" name="exchangeID" value="<?= $data['exchange']->id ?>">
        <label for="exchangeName">Edit name: </label>
        <input type="text" name="exchangeName" id="exchangeName" value="<?= $data['exchange']->name ?>">
        <input type="submit" id="submit" value="Update">
    </form>

    <p class="back"><i class="fas fa-backward back"></i> <a href="http://<?php echo URLROOT; ?>/exchanges/show">Back to Exchanges</a></p>

</div>