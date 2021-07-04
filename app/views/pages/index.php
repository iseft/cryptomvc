<?php

require APPROOT . '/views/includes/head.php'

?>

<div id="section-landing">

    <div class="navbar">
        <?php
        require APPROOT . '/views/includes/navigation.php';
        ?>
    </div>

    <div class="wrapper-landing">
            <h1><?= $data['h1'] ?></h1>
            <h2><?= $data['h2'] ?></h2>
        </div>



</div>