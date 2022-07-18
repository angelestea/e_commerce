<?php if (isset($edit) && isset($pro) && is_object($pro)): ?>
    <h1>Edit product: "<?= $pro->name ?>"</h1>
    <?php $url_action = base_url . "product/save&id=" . $pro->id; ?>
<?php else: ?>
    <h1>Create new product</h1>
    <?php $url_action = base_url . "product/save"; ?>
<?php endif; ?>

<div class="form_container">

    <form action=" <?=$url_action ?>" method="POST" enctype="multipart/form-data">
    <!--<form action="<?=base_url?>product/save" method="POST" enctype="multipart/form-data">-->
        <label for="name">Name</label>
        <input type="text" name="name" value="<?= isset($pro) && is_object($pro) ? $pro->name : ''; ?>"/>

        <label for="description">Description</label>
        <textarea name="description"><?= isset($pro) && is_object($pro) ? $pro->description : ''; ?></textarea>

        <label for="price">Price</label>
        <input type="text" name="price" value="<?= isset($pro) && is_object($pro) ? $pro->price : ''; ?>"/>

        <label for="stock">Stock</label>
        <input type="number" name="stock" value="<?= isset($pro) && is_object($pro) ? $pro->stock : ''; ?>"/>

        <label for="category">Category</label>
        <?php $categories = Utils::showCategories(); ?>
        <select name="category">
            <?php while ($cate = $categories->fetch_object()): ?>
                <option value="<?= $cate->id?>" <?= isset($pro) && is_object($pro) && $cate->id == $pro->id_category  ? 'selected' : '';?>>
                    <?= $cate->name ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <label for="image">Image:</label>
        <?php //var_dump($pro->image); ?>
        <?php if (isset($pro) && is_object($pro) && !empty($pro->image)): ?>
            <img src=" <?=base_url ?>uploads/images/<?= $pro->image ?>" class="thumb"/>
        <?php endif; ?>
        <input type="file" name="image" value="<?= isset($pro) && is_object($pro) ? $pro->image : ''; ?>"/>

        <input type="submit" id="save__product" value="Save" />
    </form>
</div>