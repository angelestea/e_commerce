<?php if (isset($_SESSION['identity'])) : ?>

    <h1>Do order</h1>

    <div class='forms__container'>

        <a href="<?= base_url ?>car/index" class='button button__small'>Review order's price</a>

        <h3>Order address:</h3>
        <br/>
        
        <?php $totalPrice = isset($_GET['totalPrice']) ? $_GET['totalPrice'] : false; 
              
              $_SESSION['totalPrice'] = $totalPrice;
              
        ?>

        <form action='<?=base_url?>order/add' method='post'>
            <label for='province'>Province</label>
            <input type='text' name="province" required>

            <label for='location'>Location</label>
            <input type='text' name='location' required>

            <label for='address'>Address</label>
            <input type='text' name='address' required>

            <input class='button button__small' type='submit'>
        </form>
    </div>

<?php else: ?>

    <h1>You are must identify</h1>

    <i>Order error</i>
    <br/>
    <br/>

    <p>You are must indentify to make this order. </p>
<?php endif; ?>