<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Cap's store</title>
        <link rel="stylesheet" href="<?= base_url ?>assets/css/styles.css" />
    </head>
    <body>
        <div id="container">
            <!-- CABECERA -->
            <header id="header">
                <div id="logo">
                    <img src="<?= base_url ?>assets/img/blue__trucker.png" alt="Camiseta Logo" />
                    <a href="<?= base_url ?>">
                        Cap's store
                    </a>
                </div>
            </header>

            <!--Menu-->
            <?php $categories = Utils::showCategories(); ?>
            <nav id="bar__nav">
                <ul>
                    <a href="<?= base_url ?>">
                        <li>Start</li>
                    </a>
                    <?php while ($cate = $categories->fetch_object()): ?>
                        <a href="<?= base_url ?>category/see&id=<?= $cate->id ?>">
                            <li><?= $cate->name ?></li>
                        </a>
                    <?php endwhile; ?>
                </ul>
            </nav>
            <main>
                <div id="content">