<h1>Hi since categories view</h1>

<a href="<?= base_url ?>category/create" class="button button__small">

    Create category

</a>

<table>
    <tr>
        <th>Id</th>
        <th>Name</th>        
    </tr>
    <?php while ($cate = $categories->fetch_object()): ?>
        <tr>
            <td><?=$cate->id?></td>
            <td><?=$cate->name?></td>
        </tr>
    <?php endwhile; ?>

</table>


