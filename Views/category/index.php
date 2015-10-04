<h3>
    <?=$model->category->getName();?>
</h3>
<?php if($model->category->getDescription()) { ?>
    <p>
        <?= $model->category->getDescription(); ?>
    </p>
<?php } ?>
<?php if(is_array($model->products)) { ?>
<div class="products">
<?php
foreach($model->products as $product) {
?>
    <div class="product">
    <form method="post" action="<?= $model->baseUrl; ?>cart/update">
    <div class="product-content"><h3><?= $product->getName(); ?></h3>
        <a href="<?= $model->baseUrl; ?>product/show/<?= $product->getId(); ?>">More info</a>
    <div class="product-thumb"><img src="<?= $model->baseUrl; ?>public/uploads/<?= $product->getImageUrl(); ?>" /></div>
    <p class="product-info">
    Price <?= $product->getPrice(); ?>
        <p>
            Description: <?= $product->getDescription(); ?>
        </p>

    <fieldset>

    <label>
        <span>Quantity</span>
        <input type="text" size="2" maxlength="2" name="product_qty" value="1" />
    </label>

    </fieldset>
    <input type="hidden" name="product_code" value="<?= $product->getId(); ?>" />
    <input type="hidden" name="type" value="add" />
    <input type="hidden" name="return_url" value="{$current_url}" />
    <div align="center"><button type="submit" class="add_to_cart">Add</button></div>
    </p></div>
    </form>
    </div>
<?php } ?>
</div>
<?php } ?>