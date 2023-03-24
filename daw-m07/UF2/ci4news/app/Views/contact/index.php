<?php
$session = \Config\Services::session();
$session->setFlashdata('captcha_text', $captcha->text);
?>

<?= $this->extend('layouts/layout_news') ?>

<?= $this->section('news_content') ?>

<div class="bg-light p-3 rounded">

    <form action="<?= base_url('contact') ?>" method="POST">
        <?= csrf_field(); ?>
        <div class="form-group mb-3">
            <div class='row'>
                <div class='col-6'>
                    <label for="email" class="form-label">Email</label>
                    <input value="<?= old('email') ?>" class="form-control <?= !empty(validation_show_error('email')) ? 'is-invalid' : '' ?>" type="text" name="email" id="email">
                </div>
                <div class='col-6'>
                    <label for="name" class="form-label">Nom</label>
                    <input value="<?= old('name') ?>" class="form-control <?= !empty(validation_show_error('name')) ? 'is-invalid' : '' ?>" type="text" name="name" id="name">
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="subject" class="form-label">Assumpte</label>
            <input value="<?= old('subject') ?>" class="form-control <?= !empty(validation_show_error('subject')) ? 'is-invalid' : '' ?>" type="text" name="subject" id="subject">
        </div>
        <div class="form-group mb-3">
            <label for="message" class="form-label">Missatge</label>
            <textarea class="form-control <?= !empty(validation_show_error('message')) ? 'is-invalid' : '' ?>" name="message" id="message" cols="45" rows="4"><?= old('message') ?></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="captcha" class="form-label">Captcha</label>
            <div class="row align-items-center">
                <div class="col-4">
                    <input value="" class="form-control <?= !empty(validation_show_error('captcha')) ? 'is-invalid' : '' ?>" type="text" name="captcha" id="captcha">
                </div>
                <div class="col">
                    <?php echo '<img src="data:image/png;base64,' . $captcha->captcha()->toImg64() . '" />'; ?>
                </div>
            </div>
        </div>
        <input type="submit" value="Enviar" class="btn btn-primary mt-1 w-100">

        <?php if (session()->getFlashdata('error')) { ?>
            <div class="alert alert-danger mt-2" role="alert">
                <?= session()->getFlashdata('error') ?>
                <?= validation_list_errors(); ?>
            </div>
        <?php } //endif error login
        ?>
    </form>
</div>
<?= $this->endSection() ?>