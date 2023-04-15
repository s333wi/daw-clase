<?= $this->extend('layout') ?>
<?= $this->section('main') ?>
<h1><?= $title ?? 'Demo CrudGen' ?></h1>
<div class="container-lg bg-light p-3 rounded shadow">
    <?= $output ?>
</div>
<?= $this->endSection() ?>