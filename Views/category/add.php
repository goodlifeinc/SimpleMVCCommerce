<p>Add category</p>
<?php if($model) : ?>
    <?= $model->error ? $model->error : ''; ?>
    <?= $model->success ? $model->success : ''; ?>
<?php endif; ?>
<form action="" method="post">
    <input type="text" placeholder="Name.." name="name" /><br />
    <input type="text" placeholder="Description.." name="description" /><br />
    <input type="hidden" name="_token" value="<?= $_SESSION['_token']; ?>" />
    <input type="submit" value="Add category" />
</form>