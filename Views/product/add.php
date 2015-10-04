<p>Add product</p>
<?php if($model) : ?>
    <?= $model->error ? $model->error : ''; ?>
    <?= $model->success ? $model->success : ''; ?>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Name.." name="name" /><br />
    <input type="text" placeholder="Description.." name="description" /><br />
    <input type="text" placeholder="Code.." name="code" /><br />
    <input type="text" placeholder="price.." name="price" /><br />
    <input type="file" name="image_url" /><br />
    Category: <br />
    <?php foreach($model->categories as $category) : ?>
    <input type="checkbox" name="categories[]" value="<?= $category->getId(); ?>"><?= $category->getName(); ?><br />
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Add product" />
</form>