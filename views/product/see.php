<?php if (isset($product)): ?>
    <h1><?= $product->name ?></h1>
    
    <div class = "detailed__product">
        
        <?php if ($product->image != null): ?>
            <img src="<?= base_url ?>uploads/images/<?= $product->image ?>" />
        <?php else: ?>
            <img src="<?= base_url ?>assets/img/default.png" />
        <?php endif; ?>

        <!--<div class="detailed__product__details">-->

        <h2><?= $product->description; ?></h2>
        <p><?= $product->price; ?></p>
        
        <p>Unities in stock: <i><?= $product->stock;?></i></p>
        
        <a href="<?=base_url?>car/add&id=<?=$product->id?>" class="button__details">Buy</a>

       
    </div>
<?php else: ?>
    <h1>Product dosen't exist</h1>
<?php endif; ?>
