<h1>Sign up</h1>

<?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
    <strong class="alert__green">Register completed succesfully</strong>
<?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
    <strong class="alert__red">Failed to register, introduce better the data</strong>
<?php endif; ?>
<?php Utils::deleteSession('register'); ?>

<form action="<?= base_url ?>user/save" method="POST">
    <label for="name">Name</label>
    <input type="text" name="name" required/>

    <label for="last_name">Last name</label>
    <input type="text" name="last_name" required/>

    <label for="email">Email</label>
    <input type="email" name="email" required/>

    <label for="password">Password</label>
    <input type="password" name="password" required/>

    <input type="submit" value="Register" />
</form>