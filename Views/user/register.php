<?php if($model) : ?>
    <?= $model->error ? $model->error : ''; ?>
<?php endif; ?>
<form action="" method="post">
    <input type="text" placeholder="Username.." name="username" />
    <input type="password" placeholder="Password.." name="password" />
    <input type="text" placeholder="Firstname.." name="firstname" />
    <input type="text" placeholder="Lastname.." name="lastname" />
    <input type="email" placeholder="Email.." name="email" />
    <input type="submit" value="register" />
</form>