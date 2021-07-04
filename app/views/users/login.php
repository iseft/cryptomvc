<?php require APPROOT . '/views/includes/head.php' ?>

<div class="navbar">
    <?php
    require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">
    <div class="wrapper-login">
        <h2>Sign in</h2>

        <form action="http://<?php echo URLROOT; ?>/users/login" method="POST">
            <input type="text" placeholder="Username *" name="username">

            <?php if ($data['usernameError'] != '') : ?>
                <span class="invalidFeedback">
                    <?php echo $data['usernameError']; ?>
                </span>
            <?php endif; ?>


            <input type="password" placeholder="Password *" name="password">

            <?php
            if ($data['passwordError'] != '') : ?>
                <span class="invalidFeedback">
                    <?php echo $data['passwordError']; ?>
                </span>
            <?php endif;  ?>


            <br>
            <button id="submit" type="submit" value="submit">Submit</button>

            <p class="options">Not registered yet? <a href="http://<?php echo URLROOT; ?>/users/register">Create an account!</a></p>

        </form>

    </div>

</div>