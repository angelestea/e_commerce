<?php if (isset($_SESSION['order']) && $_SESSION['order'] == 'completed'): ?>
    <h1>Your order was saved successfully</h1>

    <p class='alert__green__order'>
        After you cancel the total value of the order in this account: 57685465464684, this one will be processed and sended  you to your address.
    </p>
    <br/>
    <?php 
    //var_dump($order);

    if (isset($order)):
     //var_dump($order);
     //var_dump($products == $products);
    //die();
        ?>
        <h3>Order data:</h3></br>

        <pre>
                Order number: <?= $id_order ?> </br>
                Total to pay: <?= $price_products_in_car ?> $ </br>
                Products: 
        </pre>

                <table>
                            
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Unities</th>
                </tr>
                <?php if(isset($products)):
                     while ($product = $products->fetch_object()):?>
                    
                            <tr>
                            <td>
                            <?php if ($product->image != null): ?>
                                <img class='car__images' src="<?= base_url ?>uploads/images/<?= $product->image ?>" />
                            <?php else: ?>
                                <img class='car__images' src="<?= base_url ?>assets/img/default.png" />
                            <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url ?>product/see&id=<?= $product->id ?>"><?= $product->name ?></a>
                            </td>
                            <td>
                            <?= $product->price ?> $
                            </td>
                            <td>
                            <?= $product->unities ?>
                            </td>
                        </tr>
                    <?php endwhile; 
                else:
                        
                endif; ?>        
                </table>
    <?php endif; ?>
<?php elseif (isset($_SESSION['order']) && $_SESSION['order'] != 'completed'): ?>
    <h1>Your order wasn't saved successfully</h1>

    <p class='alert__red__order'>
        Intent turn better this order.
    </p>
<?php endif; ?>