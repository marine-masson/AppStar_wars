<?php ob_start(); ?>
    <ul>
        <?php foreach($product as $p): ?>
            <li><?php if($image->productImage($p->id)): ?>
                    <img src="<?php echo url('uploads', $image->productImage($p->id)->uri); ?>" alt=""/>
                <?php endif; ?>

                <h3><a href="<?php echo url('product', $p->id); ?>"><?php echo $p->title;?></a></h3>
                <p><?php echo $p->abstract; ?></p>
                <p><?php echo $p->price; ?></p>
                <div class="clearfix"></div>
                <?php if($tags = $tag->productTags($p->id)): ?>
                    <?php foreach ($tags as $t): ?>
                        <span class="tags"><?php echo $t->name; ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
                <hr/>
                <form action="<?php echo url('command');?> " method="POST">
                    <label for="quantity">Quantite : </label>
                    <input type="hidden" name="price" value="<?php echo $p->price; ?>"/>
                    <input type="hidden" name="name" value="<?php echo $p->id; ?>"/>
                    <select name="quantity" id="quantity">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <input type="submit"/>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php
$content = ob_get_clean();
include __DIR__.'/../layouts/master.php';