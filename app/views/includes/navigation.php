<nav class="top-nav">

    <div class="navlogo">
        <a class="logo" href="http://<?php echo URLROOT; ?>/pages/index">
            <i class="fab fa-bitcoin fa-3x logo"></i>
            <i class="fab fa-ethereum fa-3x logo"></i></a>
    </div>

    <ul>

        <?php

        if (!isHomeUrl()) : ?>
            <li>
                <a href="http://<?php echo URLROOT; ?>/pages/index">Home</a>
            </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])) : ?>
            <li>
                <a href="http://<?php echo URLROOT; ?>/portfolios/show">Portfolio</a>
            </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])) : ?>
            <li>
                <a href="http://<?php echo URLROOT; ?>/portfolios/inputs_outputs">Deposits/Withdrawals</a>
            </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
            <li>
                <a href="http://<?php echo URLROOT; ?>/coins/show">Coins</a>
            </li>
        <?php endif; ?>


        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
            <li>
                <a href="http://<?php echo URLROOT; ?>/exchanges/show">Exchanges</a>
            </li>
        <?php endif; ?>


        <?php if (isset($_SESSION['user_id'])) : ?>
            <li>
                <a href="http://<?php echo URLROOT; ?>/portfolios/transactions">Transactions</a>
            </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])) : ?>
            <li class="btn-login">
                <a href="http://<?php echo URLROOT; ?>/users/logout">Log out (<?= $_SESSION['username'] ?>)</a>
            </li>
        <?php elseif (substr($_SERVER['REQUEST_URI'], -5) != 'login') : ?>
            <li>
                <a href="http://<?php echo URLROOT; ?>/users/login">Login</a>
            <li>
            <?php endif; ?>

    </ul>
</nav>