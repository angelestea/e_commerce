<!-- Lateral bar-->
<aside id="bar__container">    
    <?php if (isset($_SESSION['identity'])): ?>
        <div id="car" class="block__aside">
            <h3>My buy's car</h3>
            <ul>
                <?php $status = Utils::carStatus() ?>
                <?php if ($status['products'] == 0): ?>
                    <li><a href="<?= base_url ?>car/index">Not exist products in this buy's car</a></li>
                <?php elseif ($status['products'] == 1): ?>
                    <li><a href="<?= base_url ?>car/index"><?= $status['products'] ?> product</a></li>
                <?php else: ?>
                    <li><a href="<?= base_url ?>car/index"><?= $status['products'] ?> products</a></li>
                <?php endif; ?>
                <li><a href="<?= base_url ?>car/index">Total: <?= $status['total'] ?>$</a></li>
                <li><a href="<?= base_url ?>car/index">See buy's car</a></li>
            </ul>
        </div>
    <?php endif; ?>




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
                <li><a href="<?= base_url ?>category/index">Categories manager</a></li>
                <li><a href="<?= base_url ?>product/gestion">Products manager</a></li>
                <li><a href="#">Orders manager</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['identity'])): ?>
                <li><a href="#">My orders</a></li>
                <li><a href="<?= base_url ?>user/logout">Close session</a></li>
            <?php else: ?>
                <li><a href="<?= base_url ?>user/register">Sign up</a></li>
            <?php endif; ?>
        </ul>

    </div>
</aside>
</div>

<!-- Central content-->

<div id="main__container"><br>