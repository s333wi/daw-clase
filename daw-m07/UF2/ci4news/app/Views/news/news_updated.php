<?= $this->extend('layouts/layout_news') ?>
<?= $this->section('news_content') ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">Noticia actualitzada correctament</h2>
            <p class="text-center"><a href="<?= base_url('') ?>">Tornar</a></p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>