<?= $this->extend('layouts/layout_news') ?>

<?= $this->section('news_content') ?>

<h2><?= esc($title) ?></h2>

<?= validation_list_errors() ?>
<form action="<?= base_url('create') ?>" method="POST">
    <?= csrf_field(); ?>
    <div class="form-group">

        <label for="title" class="form-label">Titol</label>
        <input type="text" name="title" id="title" class="form-control"></br>

        <label for="body">Text</label>
        <textarea name="body" id="body" cols="45" rows="4" class="form-control"></textarea></br>

        <input type="submit" value="Crear" class="btn btn-primary">
    </div>
</form>

<p><a href="<?= base_url() ?>">Tornar a noticies</a></p>


<?= $this->endSection() ?>