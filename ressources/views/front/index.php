<?php ob_start(); ?>
    <!-- <h1>Star Wars Boutique</h1> -->

        <?php foreach($products as $product): ?>
            <ul class="product">
                <li><?php if($image->productImage($product->id)): ?>
                <img src="<?php echo url('uploads', $image->productImage($product->id)->uri); ?>" alt=""/>
                <?php endif; ?>

                <h3><a href="<?php echo url('product', $product->id); ?>"><?php echo $product->title;?></a></h3>
                <p><?php echo $product->abstract; ?></p>
                <p><?php echo $product->price; ?></p>
                <div class="clearfix"></div>
                <?php if($tags = $tag->productTags($product->id)): ?>
                    <?php foreach ($tags as $t): ?>
                    <span class="tags"><?php echo $t->name; ?></span>
                <?php endforeach; ?>
                <?php endif; ?>
                </li>
                <div class="triangle"></div>
            </ul>
        <?php endforeach; ?>
<?php
$content = ob_get_clean();
include __DIR__.'/../layouts/master.php';