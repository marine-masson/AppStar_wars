<?php ob_start() ?>
    <div class="row">
            <section class="content">
                <?php foreach ($products as $name => $product): ?>
                    <div class="one-half column">
                        <?php if ($im = $image->productImage($product['product_id'])): ?>
                            <img src="<?php echo url('uploads', $im->uri) ?>">
                        <?php endif; ?>
                        <p> quantity:<?php echo $product['quantity']; ?>, total <?php echo $product['total'] ?>&euro;,
                            price: <?php echo $product['price']; ?>&euro;
                        </p>
                    </div>
                <?php endforeach; ?>
                <div class="one-half column">
                        <form action="<?php echo url('store') ?>" method="POST">
                            <?php echo token(); ?>
                            <label for="email">Email</label>
                            <?php echo(!empty($_SESSION['error']['email']))? '<small
                            class="error">'.$_SESSION['error']['email'].'</small>' : ''; ?>
                            <input type="email" name="email" id="email" value="<?php echo (!empty($_SESSION['old']['email']))? $_SESSION['old']['email'] : '' ; ?> "?>

                            <label for="cardblue">Numero de carte blue</label>
                            <?php echo(!empty($_SESSION['error']['number']))? '<small
                            class="error">'.$_SESSION['error']['number'].'</small>' : ''; ?>
                            <input type="text" name="number" id="number" value="" placeholder=""/>

                            <label for="address">addresse</label>
                            <?php echo (!empty($_SESSION['error']['addresse']))? '<small class="error">'.$_SESSION['error']['addresse'].'</small>' : '' ; ?>
                            <textarea name="addresse" class="u-full-width" placeholder="Que la force soit avec toi..."
                                      id="addresse"><?php echo (!empty($_SESSION['old']['addresse'])) ? $_SESSION['old']['addresse'] : ''; ?></textarea>
                            <br/>
                            <input type="submit" value="command">
                        </form>
                    </div>
            </section>
        </div>
<?php $content = ob_get_clean() ?>
<?php include __DIR__ . '/../layouts/master.php' ?>