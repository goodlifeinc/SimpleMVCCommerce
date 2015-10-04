<ul>
    <?php foreach ($model->categories as $category) { ?>
        <li>
            <a href="<?= $model->baseUrl; ?>category/show/<?= $category->getId(); ?>"><?= $category->getName(); ?></a>
        </li>

    <?php } ?>
</ul>