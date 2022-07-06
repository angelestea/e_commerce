<?php if(isset($gestion)): ?>

<h1>Orders manage</h1>

<?php else: ?>

<h1>My orders</h1>

<?php endif; ?>

<table>

    <tr>
        <th>Nº</th>
        <th>Price</th>
        <th>Date</th>
        <th>State</th>
        <th>Date</th>
        <th>Hour</th>
    </tr>

        <?php
        while($ord = $orders->fetch_object()):

            ?>

            <tr>
                <td>
                    <a href="<?=base_url?>order/detail&id=<?=$ord->id?>"><?=$ord->id?></a>
                </td>
                <td>
                    <?= $ord->price ?> $
                </td>
                <td>
                    <?= $ord->date ?>
                </td>
                <td>
                    <?= Utils::showStatus($ord->state); ?>
                </td>
                <td>
                    <?= $ord->date ?>
                </td>
                <td>
                    <?= $ord->hour ?>
                </td>
            </tr>

        <?php endwhile; ?>

</table>