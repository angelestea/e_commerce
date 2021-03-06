<h1>Buy's car</h1>

<table>

    <tr>
        <?php if (isset($_SESSION['car'])) : ?>
            <th>Get out of car</th>
        <?php elseif(isset($dataValue) && $dataValue->num_rows > 0):?>
            <th>Get out of car</th>
        <?php endif; ?>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <?php if (isset($_SESSION['car'])) : ?>
            <th>Unities</th>
        <?php elseif(isset($dataValue) && $dataValue->num_rows > 0):?>
            <th>Unities</th>
        <?php endif; ?>
    </tr>

    <?php if (isset($_SESSION['car']) && count($_SESSION['car']) >= 1 && !isset($dataValue)): ?>
        <?php
        $count = 0;
        $totalPrice = 0;
        $totalUnities = 0;
        foreach ($car as $index => $element):

            $product = $element['product'];
            $count++;
            $totalPrice += $product->price * $element['unities'];
            $totalUnities += $element['unities'];
            ?>

            <tr>

                <?php if (isset($_SESSION['car']) && count($_SESSION['car']) >= 1): ?>
                    <td>
                        <a href="<?= base_url ?>car/remove&index=<?= $index ?>" class="button order__button button__remove">Get out product</a>
                    </td>
                <?php endif; ?>

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
                    <?= $element['unities'] ?>
                    <div class='operators_container'>
                        <a href='<?= base_url ?>car/up&index=<?= $index ?>' class='up__down'>+</a>
                        <a href='<?= base_url ?>car/down&index=<?= $index ?>' class='up__down'>-</a>
                    </div>
                </td>
            </tr>

        <?php endforeach; ?>
        <tr>
            
            <?php if (isset($_SESSION['car'])) : ?>
            <td>
                Total
            </td>
            <td>

            </td>
        <?php elseif(isset($dataValue) && $dataValue->num_rows > 0):?>
            <td>
                Total
            </td>
            <td>

            </td>
        <?php endif; ?>
            <td>
                Diferent products: <?= $count ?>
            </td>
            <td>
                Total price: <?= $totalPrice ?> $
            </td>
            <td>
                Total unities: <?= $totalUnities ?>
            </td>

        </tr>

    <?php
    elseif (isset($dataValue) || $dataValue->num_rows >= 1 || count($_SESSION['car']) > 0):
//        var_dump(count($_SESSION['car']));
//        die();
        //echo "Ok 1!";
        $count = 0;
        $totalPrice = 0;
        $totalUnities = 0;
        //var_dump($dataValue->num_rows);
        //die();
        while ($product = $dataValue->fetch_object()):
            //var_dump($product);


            $product_name = $product->name;
            $count++;
            $totalPrice += (float) $product->price * (float) $product->unities;
            $totalUnities += (int) $product->unities;
            $id_product = (int) $product->id_product;

            $db = Database::connect();
            
            $consult = "SELECT stock FROM products WHERE id={$product->id_product}";
            
            $consult = $db->query($consult)->fetch_object()->stock;
            
            $stock = (int)$consult;
            
            ?>

            <tr>

                <?php if (isset($product)): ?>
                    <td>
                        <a href="<?= base_url ?>car/remove&index=<?= $product->id_product ?>" class="button order__button button__remove">Get out product</a>
                    </td>
                <?php endif; ?>

                <td>
                    <?php if ($product->image != null): ?>
                        <img class='car__images' src="<?= base_url ?>uploads/images/<?= $product->image ?>" />
                    <?php else: ?>
                        <img class='car__images' src="<?= base_url ?>assets/img/default.png" />
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url ?>product/see&id=<?= $product->id_product ?>"><?= $product_name ?></a>
                </td>
                <td>
                    <?= $product->price ?> $
                </td>
                <td>
                    <?= $product->unities ?>
                    <div class='operators_container'>
                        <?php if($product->unities < $stock):?>
                        <a href='<?= base_url ?>car/up&id_product=<?= $product->id_product ?>&data=<?= true ?>&product_name=<?= $product->name ?>&product_unities=<?= $product->unities ?>&product_price=<?= $product->price ?>&image=<?=$product->image?>' class='up__down'>+</a>
                        <?php endif; ?>
                            <?php if ($product->unities > 1): ?>
                            <a href='<?= base_url ?>car/down&id_product=<?= $product->id_product ?>&data=<?= true ?>&product_name=<?= $product->name ?>&product_unities=<?= $product->unities ?>&product_price=<?= $product->price ?>&image=<?=$product->image?>' class='up__down'>-</a>
                        <?php elseif ($product->unities == 1): ?>
                            <a href="<?= base_url ?>car/remove&index=<?= $product->id_product ?>" class='up__down'>-</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>

        <?php endwhile; ?>
        <tr>
            
            <?php if (isset($_SESSION['car'])) : ?>
            <td>
                Total
            </td>
            <td>

            </td>
        <?php elseif(isset($dataValue) && $dataValue->num_rows > 0):?>
            <td>
                Total
            </td>
            <td>

            </td>
        <?php endif; ?>
            <td>
                Diferent products: <?= $count ?>
            </td>
            <td>
                Total price: <?= $totalPrice ?> $
            </td>
            <td>
                Total unities: <?= $totalUnities ?>
            </td>

        </tr>


    <?php elseif (isset($_SESSION['car']) && count($_SESSION['car']) >= 1 && isset($dataValue)): ?>
        <?php //echo "Ok 2!" ?>
        <?php
        $count = 0;
        $totalPrice = 0;
        $totalUnities = 0;
        foreach ($car as $index => $element):
//                    var_dump($car );
//                            var_dump($index);


            $product = $element['product'];
            $count++;
            $totalPrice += $product->price * $element['unities'];
            $totalUnities += $element['unities'];
            ?>

            <tr>

                <?php if (isset($_SESSION['car']) && count($_SESSION['car']) >= 1): ?>
                    <td>
                        <a href="<?= base_url ?>car/remove&index=<?= $index ?>" class="button order__button button__remove">Get out product</a>
                    </td>
                <?php endif; ?>

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
                    <?= $element['unities'] ?>
                    <div class='operators_container'>
                        <a href='<?= base_url ?>car/up&index=<?= $index ?>' class='up__down'>+</a>
                        <?php if ($element['unities'] > 2): ?>
                            <a href='<?= base_url ?>car/down&index=<?= $index ?>' class='up__down'>-</a>
                        <?php elseif ($element['unities'] == 1): ?>
                            <a href='<?= base_url ?>car/remove&index=<?= $index ?>' class='up__down'>-</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>

        <?php endforeach; ?>
        <tr>
            <td>
            </td>
            <td>
                Total
            </td>
            <td>
                Diferent products: <?= $count ?>
            </td>
            <td>
                Total price: <?= $totalPrice ?> $
            </td>
            <td>
                Total unities: <?= $totalUnities ?>
            </td>

        </tr>

    <?php else: ?>
        <?php //echo "Ok!"; ?>
        <tr>
            <td>
                Total
            </td>
            <td>
                Diferent products: 0
            </td>
            <td>
                Total price: 0.00 $
            </td>
            <td>
                Total unities: 0
            </td>

        </tr>
        <p class="text__center">This car is empty yet</p>
    <?php endif; ?>

</table>
<br/>

<?php if (isset($_SESSION['car']) && count($_SESSION['car']) >= 1):

    $status = Utils::carStatus();
    ?>
    
    <a href="<?= base_url ?>order/make" class="button order__button ">Order</a>
    <a href="<?= base_url ?>car/delete__all" class="button order__button button__red">Voiding car</a>

<?php elseif (isset($dataValue) && $dataValue->num_rows >= 1):
    
    $db = Database::connect();
    
    $allCar = "SELECT * FROM cars c INNER JOIN products p ON p.id = c.id_product WHERE id_user={$_SESSION['identity']->id};";
   
//    echo $allCar;
//    
//    die();
    
    $consult = $db->query($allCar)/*->fetch_object()->unities*/;
    
    
    
    $outOfStock = 0;
    
//    var_dump($consult->fetch_object());
//    
//    var_dump($consult->fetch_object());
//    
//    die();
    
    while($pro = $consult->fetch_object()):
        
        if($pro->stock == 0):
            var_dump($pro);
            $outOfStock++; 
        endif;
        
    endwhile;
    
//    var_dump($outOfStock);
//    die();
    
    
    ?>
    <?php if($outOfStock == 0): ?>
        <a href="<?= base_url ?>order/make&data=<?=true?>&totalPrice=<?=$totalPrice?>" class="button order__button ">Order</a>
        <a href="<?= base_url ?>car/delete__all" class="button order__button button__red">Voiding car</a>
    <?php else: ?>
        <a href="<?= base_url ?>car/delete__all" class="button order__button button__red">You should to void this car</a>
    <?php endif; ?>

<?php endif; ?>
