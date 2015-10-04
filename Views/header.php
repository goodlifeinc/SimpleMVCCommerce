<?php
$userRole = $_SESSION['role_id'];
?>
<html>
<head>
    <link rel="stylesheet" href="<?= $model->baseUrl;?>public/css/style.css" />
    <script src="<?= $model->baseUrl;?>public/node_modules/jquery/dist/jquery.js"></script>
</head>
<body>

<header>
    <a href="<?= $model->baseUrl; ?>">SimpleMVC PHP Framework ECommerce</a> |
    <a href="<?= $model->baseUrl; ?>cart/view">View cart</a> |
    <a href="<?= $model->baseUrl; ?>user/profile">Profile</a> |
    <?php if($userRole != 3) { ?>
        <a href="<?= $model->baseUrl; ?>category/add">Add category</a> |
        <a href="<?= $model->baseUrl; ?>product/add">Add product</a> |
    <?php } ?>
    <a href="<?= $model->baseUrl; ?>user/logout">Logout</a>
</header>