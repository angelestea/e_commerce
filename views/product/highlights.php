<h1>Some of our products</h1>

<?php //if(isset($_SESSION['re_login'])):
    
    //unset($_SESSION['re_login']);
    
//endif; ?>

<?php while ($pro = $products->fetch_object()): ?>
    <?php //$pro = $proShow ?>
    <?php if($pro->stock > 0): ?>
    <div class="product">
        <a href="<?=base_url?>product/see&id=<?=$pro->id?>">
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
                    
//          var_dump($num_unities);
//          die();
                    
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
    <?php endif; ?>    

<?php endwhile; ?>
