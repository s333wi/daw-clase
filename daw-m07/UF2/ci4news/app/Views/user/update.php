<?= $this->extend('layouts/layout_news') ?>
<?= $this->section('news_content') ?>
<?php
?>
<?= validation_list_errors() ?>
<form action="<?= base_url('users/update') . '/' . $user['id'] ?>" method="POST">
    <?= csrf_field(); ?>
    <div class="form-group">

        <label for="title" class="form-label">Nom</label>
        <input value="<?= $user['name'] ?>" class="form-control" type="text" name="name" id="name">
        <br>

        <label for="email" class="form-label">Email</label>
        <input value="<?= $user['email'] ?>" class="form-control" type="text" name="email" id="email">
        <br>

        <label for="role_code" class="form-label">Rol</label>
        <select name="role_code" id="role_code" class="form-control">
            <?php foreach ($roles as $role) : ?>
                <option value="<?= $role['code'] ?>" <?= ($user['role_code'] == $role['code']) ? 'selected' : '' ?>><?= $role['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Actualitzar" class="btn btn-primary mt-2">
    </div>
</form>

<p><a href="<?= base_url('users/dashboard') ?>">Tornar a usuaris</a></p>
<?= $this->endSection() ?>