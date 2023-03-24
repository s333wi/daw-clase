<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/formularis.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/2a59fbfff2.js" crossorigin="anonymous"></script>
</head>

<body class="register">
    <div class="register-container d-flex align-items-center justify-content-center vh-100">
        <div class="container w-75">
            <div class="row box-shadow d-flex justify-content-center">
                <div class="col-6 bg-body px-5 pb-5 rounded shadow-lg">
                    <!-- Logo -->
                    <div class="d-flex text-end close-container mb-5">
                        <a id="close-btn" href="<?= base_url() ?>"><i class="fa-regular fa-circle-xmark fa-xl text-dark"></i></a>
                    </div>

                    <div class="d-flex align-items-center">
                        <a href="<?= base_url() ?>" class="text-decoration-none d-flex text-dark align-items-center">
                            <img class="me-2" src="<?= base_url('assets/img/logo.png') ?>" loading="lazy" alt="" width="48" />
                            <div id="text">
                                <div id="effect" class="d-flex">
                                    <span class="fs-4">Coding Souls</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <h2 class="fw-bold text-center py-5">Uneix-te a nosaltres rei</h2>

                    <!-- Formulari login -->
                    <form action="<?= base_url('register') ?>" method="POST">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="username" class="mb-1">Nom d'usuari</label>
                                <input type="text" name="name" class="form-control <?= !empty(validation_show_error('name')) ? 'is-invalid' : '' ?>" id="username" value="<?= old('name') ?>" required />
                            </div>
                            <div class="col">
                                <label for="names" class="mb-1">Nom i cognoms</label>
                                <input type="text" name="nomcognoms" class="form-control <?= !empty(validation_show_error('nomcognoms')) ? 'is-invalid' : '' ?>" value="<?= old('nomcognoms') ?>" id="names" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-8">
                                <label for="email" class="mb-1">Correu electrònic</label>
                                <input type="text" name="email" class="form-control <?= !empty(validation_show_error('email')) ? 'is-invalid' : '' ?>" id="email" value="<?= old('email') ?>" required />
                                <div class="form-helper">
                                    <small class="text-muted">Tranquil, no t'enviarem spam</small>
                                </div>
                            </div>
                            <div class="col">
                                <label for="age" class="mb-1">Edat</label>
                                <input type="number" name="edat" class="form-control <?= !empty(validation_show_error('edat')) ? 'is-invalid' : '' ?>" value="<?= old('edat') ?>" id="age" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="password" class="form-label mb-1">Contrasenya</label>
                                <input type="password" name="password" class="form-control <?= !empty(validation_show_error('password')) ? 'is-invalid' : '' ?>" id="password" required />
                                <div class="form-helper">
                                    <small class="text-muted">La contrasenya ha de tenir almenys 4 caràcters</small>
                                </div>
                                <?php if (service('validation')->getError('password')) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= service('validation')->getError('password') ?>
                                    </div>
                                <?php } //endif error password
                                ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="passwordConfirm" class="form-label mb-1">Confirma la contrasenya</label>
                                <input type="password" name="password_confirm" class="form-control <?= !empty(validation_show_error('password_confirm')) ? 'is-invalid' : '' ?>" id="passwordConfirm" required />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registra't</button>
                        <?php if (session()->getFlashdata('error')) { ?>
                            <div class="alert alert-danger mt-2" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <?= validation_list_errors(); ?>
                            </div>
                        <?php } //endif error login
                        ?>
                    </form>



                    <div class="mt-3">
                        <span>Ja tens un compte? <a href="<?= base_url('login') ?>">Connecta't</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>