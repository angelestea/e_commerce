<?php if (!isset($_SESSION['re_login'])): ?>
    <!-- Lateral bar-->
    <aside id="bar__container">    
        <?php if (isset($_SESSION['identity'])): ?>
            <?php
            //var_dump($GLOBALS); 

            $db = Database::connect();
            $varify_products = "SELECT COUNT(*) as 'rows' FROM cars WHERE id_user={$_SESSION['identity']->id}";

            $varify_productsTwo = $db->query($varify_products);

            if ($varify_productsTwo) {
                $varify_productsTwo = $varify_productsTwo->fetch_object();
                $varify_productsTwo = (int)$varify_productsTwo->rows;
//                    var_dump($varify_productsTwo);
//                    die();
            }
            ?>
            <div id="car" class="block__aside">
                <h3>My buy's car</h3>
                <ul>
                    <?php $status = Utils::carStatus() ?>
                    <?php
                    if (isset($_SESSION['car'])):

                        $db = Database::connect();
                        $sqlProducts = "SELECT COUNT(id_user) as 'value' FROM cars WHERE id_user={$_SESSION['identity']->id}";

                        $total_products = $db->query($sqlProducts);

                        if ($total_products->num_rows > 0):
                        //unset($_SESSION['car']);
                        endif;


                    endif;
                    ?>
                    <?php
                    if ($status['products'] == 0):
                        //echo "status products == 0";
                        $db = Database::connect();
                        $sqlProducts = "SELECT COUNT(id_user) as 'value' FROM cars WHERE id_user={$_SESSION['identity']->id}";

                        $sqlPrice = "SELECT SUM(price*unities) as 'total_price' FROM cars WHERE id_user={$_SESSION['identity']->id}";

                        $total_price = $db->query($sqlPrice);

                        $total_price = $total_price->fetch_object();

                        $total_price = (float) $total_price->total_price;


                        $total_products = $db->query($sqlProducts);

                        $total_products = $total_products->fetch_object();

                        $total_products = (int) $total_products->value;

                        //echo $total_price;
//                        
//                        die();
//                                                
                        if (isset($total_products) && $total_products == 0):
                            ?>

                            <li><a href="<?= base_url ?>car/index">Not exist products in this buy's car</a></li>

                        <?php elseif ($total_products && $total_products == 1): ?>

                            <li><a href="<?= base_url ?>car/index"><?= $total_products ?> product</a></li>

                        <?php elseif ($total_products && $total_products > 1): ?>

                            <li><a href="<?= base_url ?>car/index"><?= $total_products ?> products</a></li>

                        <?php elseif (!isset($total_products)): ?>
                            <li><a href="<?= base_url ?>car/index">Not exist products in this buy's car</a></li>

                        <?php endif; ?>

                    <?php elseif ($status['products'] == 1): ?>
                        <li><a href="<?= base_url ?>car/index"><?= $status['products'] ?> product</a></li>
        <?php elseif ($status['products'] > 1): ?>
            <?php //var_dump($status['products']);die();   ?>
                        <li><a href="<?= base_url ?>car/index"><?= $status['products'] ?> products</a></li>                        
            <?php endif; ?>
                    <li><a href="<?= base_url ?>car/index">Total: <?= isset($total_price) ? $total_price : $status['total'] ?>$</a></li>
                    <li><a href="<?= base_url ?>car/index">See buy's car</a></li>
                </ul>
            </div>
            <?php else: ?>
                <?php $_SESSION['re_login'] = 0;
                unset($_SESSION['re_login']); ?>
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
                    <li><a href="<?= base_url ?>order/gestion">Orders manager</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['identity'])): ?>
                    <li><a href="<?= base_url ?>order/my_orders">My orders</a></li>
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

<?php endif; ?>