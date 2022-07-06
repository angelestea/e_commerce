<h1>Buy's car</h1>

<table>

    <tr>
        <?php var_dump($dataValue->num_rows); ?>
        <?php if (isset($_SESSION['car']) || isset($dataValue)): ?>
            <th>Get out of car</th>
        <?php endif; ?>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Unities</th>

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
            <td>
                Total
            </td>
            <td>

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

    <?php
    elseif (isset($dataValue) || $dataValue->num_rows >= 1 || count($_SESSION['car']) > 0):
//        var_dump(count($_SESSION['car']));
//        die();
        echo "Ok 1!";
        $count = 0;
        $totalPrice = 0;
        $totalUnities = 0;
        var_dump($dataValue->num_rows);
        //die();
        while ($product = $dataValue->fetch_object()):
            //var_dump($product);


            $product_name = $product->name;
            $count++;
            $totalPrice += (float) $product->price * (float) $product->unities;
            $totalUnities += (int) $product->unities;
            $id_product = (int) $product->id_product;

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
                        <a href='<?= base_url ?>car/up&id_product=<?= $product->id_product ?>&data=<?= true ?>&product_name=<?= $product->name ?>&product_unities=<?= $product->unities ?>&product_price=<?= $product->price ?>&image=<?=$product->image?>' class='up__down'>+</a>
                        <?php if ($product->unities > 1): ?>
                            <a href='<?= base_url ?>car/down&id_product=<?= $product->id_product ?>&data=<?= true ?>&product_name=<?= $product->name ?>&product_unities=<?= $product->unities ?>&product_price=<?= $product->price ?>' class='up__down'>-</a>
                        <?php elseif ($product->unities == 1): ?>
                            <a href="<?= base_url ?>car/remove&index=<?= $product->id_product ?>" class='up__down'>-</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>

        <?php endwhile; ?>
        <tr>
            <td>
                Total
            </td>
            <td>

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


    <?php elseif (isset($_SESSION['car']) && count($_SESSION['car']) >= 1 && isset($dataValue)): ?>
        <?php echo "Ok 2!" ?>
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
        <?php echo "Ok!"; ?>
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

<?php elseif (isset($dataValue) && $dataValue->num_rows >= 1): ?>

    <a href="<?= base_url ?>order/make&data=<?=true?>&totalPrice=<?=$totalPrice?>" class="button order__button ">Order</a>
    <a href="<?= base_url ?>car/delete__all" class="button order__button button__red">Voiding car</a>

<?php endif; ?>
