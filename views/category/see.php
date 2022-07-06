<?php if (isset($category)): ?>

    <h1><?= $category->name; ?></h1>

    <?php if ($products->num_rows == 0): ?>
        <p>Not exist products to show in this category</p>
    <?php else: ?>

        <?php while ($pro = $products->fetch_object()): ?>
            <?php //$pro = $proShow ?>
            <div class="product">
                <a href="<?= base_url ?>product/see&id=<?= $pro->id ?>">
                    <?php if ($pro->image != null): ?>
                        <img src="<?= base_url ?>uploads/images/<?= $pro->image ?>" />
                    <?php else: ?>
                        <img src="<?= base_url ?>assets/img/default.png" />
                    <?php endif; ?>
                    <h2><?= $pro->name; ?></h2>
                    <p><?= $pro->price; ?></p>
                </a>
                <?php
                    $db = Database::connect();
                    $sql_products = "SELECT * FROM cars WHERE id_product={$pro->id}";
                    
//                    var_dump($num_unities);
//                    die();
                    
                    $num_products = $db->query($sql_products);?>

                    <?php if($num_products->num_rows > 0): ?>
                    <?php $sql_unities = "SELECT unities FROM cars WHERE id_product={$pro->id}";
                    
                          $num_unities = $db->query($sql_unities);
                          $num_unities = $num_unities->fetch_object()->unities;
                          $num_unities = (int)$num_unities;
                    ?>
                        <a href='<?= base_url ?>car/up&id_product=<?= $pro->id ?>&data=<?= true ?>&product_name=<?= $pro->name ?>&product_unities=<?= $num_unities ?>&product_price=<?= $pro->price ?>&image=<?=$pro->image?>' class="button">Buy</a>
                    <?php else: ?>
                        <a href="<?=base_url?>car/add&id=<?=$pro->id?>" class="button">Buy</a>
                    <?php endif;?>
            </div>
        <?php endwhile; ?>


    <?php endif; ?>
<?php else: ?>
    <h1>This category dosen't exist</h1>

<?php endif; ?>
