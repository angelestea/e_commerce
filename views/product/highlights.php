<h1>Some of our products</h1>

<?php while ($pro = $products->fetch_object()): ?>
    <?php //$pro = $proShow ?>
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
        <a href="" class="button">Buy</a>
    </div>
<?php endwhile; ?>
