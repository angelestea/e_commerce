<?php if (isset($_SESSION['identity'])): ?>

    <?= header("Location:" . base_url) ?>

<?php else: ?>

    <div class="forms__container">

        <h1>Login</h1>

        <form action="<?= base_url ?>user/login" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" required/>

            <label for="password">Password</label>
            <input type="password" name="password" required/>

            <input type="submit" value="Login" />
        </form>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['re_login'])): 
    
    unset($_SESSION['re_login']);
    
endif;