<!-- Lateral bar-->
<aside id="bar__container">    
    <div id="login" class="block__aside">
        <?php if (!isset($_SESSION['identity'])): ?>
            <h3>Get in the store</h3>
            <form action="<?= base_url ?>user/login" method="post">
                <label for="email">Email</label>
                <input type="email" name="email">
                <label for="password">Password</label>
                <input type="password" name="password">
                <input type="submit" name="submit" value="Submit">
            </form>
        <?php else: ?>
            <h3>Welcome <?= $_SESSION['identity']->name ?></h3>
        <?php endif; ?>

        <ul>
            <?php if (isset($_SESSION['admin'])): ?>
                <li><a href="#">Categories manager</a></li>
                <li><a href="#">Products manager</a></li>
                <li><a href="#">Orders manager</a></li>
            <?php endif; ?>
            <?php if(isset($_SESSION['identity'])):?>
                <li><a href="#">My orders</a></li>
                <li><a href="<?= base_url ?>user/logout">Close session</a></li>
            <?php endif; ?>
        </ul>

    </div>
</aside>
</div>

<!-- Central content-->

<div id="main__container"><br>