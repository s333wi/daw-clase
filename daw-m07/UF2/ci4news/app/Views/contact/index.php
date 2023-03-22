<?php
$session = \Config\Services::session();
$session->setFlashdata('captcha_text', $captcha->text);
?>

<?= $this->extend('layouts/layout_news') ?>

<?= $this->section('news_content') ?>

<form action="<?= base_url('contact') ?>" method="POST">
    <?= csrf_field(); ?>
    <div class="form-group">
        <div class='row'>
            <div class='col-6'>
                <label for="email" class="form-label">Email</label>
                <input value="<?= old('email') ?>" class="form-control" type="text" name="email" id="email">
            </div>
            <div class='col-6'>
                <label for="name" class="form-label">Nom</label>
                <input value="" class="form-control" type="text" name="name" id="name">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="subject" class="form-label">Assumpte</label>
        <input value="" class="form-control" type="text" name="subject" id="subject">
    </div>
    <div class="form-group">
        <label for="message" class="form-label">Missatge</label>
        <textarea class="form-control" name="message" id="message" cols="45" rows="4"></textarea>
    </div>
    <div class="form-group">
        <label for="captcha" class="form-label">Captcha</label>
        <div class="row">
            <div class="col-4">
                <input value="" class="form-control" type="text" name="captcha" id="captcha">
            </div>
            <div class="col">
                <?php echo '<img src="data:image/png;base64,' . $captcha->captcha()->toImg64() . '" />'; ?>
            </div>
        </div>
    </div>
    <input type="submit" value="Enviar" class="btn btn-primary mt-1 w-100">
</form>
<?= $this->endSection() ?>