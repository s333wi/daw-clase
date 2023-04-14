<?php
$session = \Config\Services::session();
$session->setFlashdata('captcha_text', $captcha->text);
// if (session()->has('errors')) {
//     echo "<pre>";
//     print_r($_SESSION);
//     echo "</pre>";
//     die;
// }

?>
<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            <div class="card">
                <h2 class="card-header"><?= lang('Auth.register') ?></h2>
                <div class="card-body">

                    <?= view('App\Views\Auth\_message_block') ?>

                    <form action="<?= base_url('register') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label for="email"><?= lang('Auth.email') ?></label>
                            <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                            <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                        </div>

                        <div class="form-group">
                            <label for="username"><?= lang('Auth.username') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                        </div>

                        <div class="form-group">
                            <label for="password"><?= lang('Auth.password') ?></label>
                            <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="pass_confirm"><?= lang('Auth.repeatPassword') ?></label>
                            <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="captcha" class="form-label">Captcha</label>
                            <input value="" class="form-control <?php if (session('errors.captcha')) : ?>is-invalid<?php endif ?>" type="text" name="captcha" id="captcha">
                            <div class="d-flex justify-content-center mt-4">
                                <?php echo '<img src="data:image/png;base64,' . $captcha->captcha()->toImg64() . '" />'; ?>
                            </div>
                        </div>
                </div>

                <br>

                <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                </form>


                <hr>

                <p><?= lang('Auth.alreadyRegistered') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
            </div>
        </div>

    </div>
</div>
</div>

<?= $this->endSection() ?>