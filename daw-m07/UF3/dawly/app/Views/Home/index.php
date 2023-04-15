<?= $this->extend('layout') ?>
<?= $this->section('main') ?>
<div class="content vh-100 d-flex align-items-center justify-content-center flex-column">
    <h1>Escurça el teu enllaç de manera anònima</h1>
    <form action="shorten" method="post" class="w-75">
        <div class="form-group d-flex align-items-baseline">
            <input type="text" name="url" id="url" placeholder="Enllaç a escurçar" required class="form-control w-100 me-2">
            <button type="submit" class="btn btn-primary mt-3">Escurçar</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>