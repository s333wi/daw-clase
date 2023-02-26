<?= $this->extend('layouts/layout_news') ?>
<?= $this->section('news_content') ?>

<?= validation_list_errors() ?>
<form action="<?= base_url('update') . '/' . $news['slug'] ?>" method="POST">
    <?= csrf_field(); ?>
    <div class="form-group">

        <label for="title" class="form-label">Titol</label>
        <input value="<?= $news['title'] ?>" class="form-control" type="text" name="title" id="title">
        <br>

        <label for="body" class="form-label">Text</label>
        <textarea class="form-control" name="body" id="body" cols="45" rows="4"><?= $news['body'] ?></textarea></br>

        <input type="submit" value="Actualitzar" class="btn btn-primary">
    </div>
</form>

<p><a href="<?= base_url() ?>">Tornar a noticies</a></p>
<?= $this->endSection() ?>