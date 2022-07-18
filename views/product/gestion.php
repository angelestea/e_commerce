<h1>Products gestion</h1>

<a href="<?= base_url ?>product/create" class="button button__small">
    Create product
</a>

<?php if (isset($_SESSION['product']) && $_SESSION['product'] == 'complete'): ?>
    <strong class="alert__green">The product has been create succesfully</strong>
<?php elseif (isset($_SESSION['product']) && $_SESSION['product'] != 'complete'): ?>	
    <strong class="alert__red">The product hasn't been create succesfully</strong>
<?php endif; ?>
<?php Utils::deleteSession('product'); ?>

<?php if (isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>
    <strong class="alert__green">El producto se ha borrado correctamente</strong>
<?php elseif (isset($_SESSION['delete']) && $_SESSION['delete'] != 'complete'): ?>	
    <strong class="alert__red">El producto NO se ha borrado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('delete'); ?>

<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Actions</th>
    </tr>
    <?php while ($pro = $products->fetch_object()): ?>
        <tr>
            <td><?= $pro->id; ?></td>
            <td><?= $pro->name; ?></td>
            <td><?= $pro->price; ?></td>
            <td><?= $pro->stock; ?></td>
            <td>
                <a href="<?= base_url ?>product/edit&id=<?= $pro->id ?>" class="button button__small">Edit</a>
                <a href="<?= base_url ?>product/delete&id=<?= $pro->id ?>" class="button button__small button__red">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
