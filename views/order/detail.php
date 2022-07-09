<h1>Order's detail</h1>

<?php //var_dump($order) ?>

<?php if (isset($order) && isset($products_a)): ?>

    <?php if (isset($_SESSION['admin'])): ?>
        <h3>Change order status</h3>
        <?php //var_dump($order->state); var_dump(Utils::showStatus($order->state));?>
        <form action='<?= base_url ?>order/state' method='POST'>  
            <input type='hidden' value='<?= $order->id ?>' name='id_order'/>
            <select name='state'>
                <option value='confirm' <?= Utils::showStatus($order->state) == 'earing' ? 'selected' : ''; ?>>Earring</option>
                <option value='preparation' <?= Utils::showStatus($order->state) == 'in preparation' ? 'selected' : ''; ?>>In preparation</option>
                <option value='ready' <?= Utils::showStatus($order->state) == 'preparated to send' ? 'selected' : ''; ?>>Preparation to send</option>
                <option value='sended' <?= Utils::showStatus($order->state) == 'sended' ? 'selected' : ''; ?>>Sended</option>
            </select>
            <input type="submit" value='change status'/>
        </form></br>
    <?php endif; ?>

        
    <h3>User:</h3>

    <pre>
        Name:<?=$user->name?></br>
        Last:<?=$user->last_name?></br>
        Email:<?=$user->email?></br>
    </pre>    
        
    <h3>Must be sended:</h3></br>

    <pre>
        Province: <?= $order->province ?> </br>
        Location: <?= $order->location ?> </br>
        Address: <?= $order->address ?> </br>
    </pre>        

    <h3>Order data:</h3></br>

    <pre>
        Order number: <?= $order->id ?> </br>
        Total to pay: <?= $order->price ?> $ </br>
        Status: <?= Utils::showStatus($order->state); ?> </br>
        Products: 
    </pre>

    <table>

        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Unities</th>
        </tr>
        <?php //var_dump(count($products_a));
        //die(); ?>

        <?php 
        $count = 0;
        while (count($products_a) > $count):   
            
            $product = $products_a[$count]->fetch_object();
            //var_dump($product);
            $image = $product->image;
            $name = $product->name;
            $id_product = $product->id_product;
            $price = $product->price;
            $unities = $product->unities;
            
//            var_dump($image);
//            var_dump($name);
//            var_dump($id_product);
//            var_dump($price);
//            var_dump($unities);
            //die();
        
//            var_dump($products_a[$count]->fetch_object()->image);
//            die();
            
            ?>
            <tr>
                <td>
                    <?php if ($image != null): ?>
                        <img class='car__images' src="<?= base_url ?>uploads/images/<?= $image ?>" />
                    <?php else: ?>
                        <img class='car__images' src="<?= base_url ?>assets/img/default.png" />
        <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url ?>product/see&id=<?= $id_product ?>"><?= $name ?></a>
                </td>
                <td>
        <?= $price ?> $
                </td>
                <td>
        <?= $unities;
            $count++;   ?>
                </td>
            </tr>
    <?php endwhile; ?>
    </table>

<?php else: ?>
    <h1 class="alert__red error__detail">Error</h1>
<?php endif; ?>