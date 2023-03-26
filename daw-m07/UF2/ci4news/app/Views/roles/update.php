<?= $this->extend('layouts/layout_news') ?>
<?= $this->section('news_content') ?>
<?php
?>
<?= validation_list_errors() ?>
<form action="<?= base_url('roles/update') . '/' . $role['id'] ?>" method="POST">
    <?= csrf_field(); ?>
    <div class="form-group">

        <label for="name" class="form-label">Nom</label>
        <input value="<?= $role['name'] ?>" class="form-control" type="text" name="name" id="name">
        <br>

        <label for="code" class="form-label">Codi</label>
        <input value="<?= $role['code'] ?>" class="form-control" type="text" name="code" id="code">
        <br>

        <label for="description" class="form-label">Descripcio</label>
        <textarea class="form-control" name="description" id="description" cols="45" rows="4"><?= $role['description'] ?></textarea></br>

        <input type="submit" value="Actualitzar" class="btn btn-primary mt-2">
    </div>
</form>

<p><a href="<?= base_url('users/dashboard') ?>">Tornar a usuaris</a></p>
<?= $this->endSection() ?>