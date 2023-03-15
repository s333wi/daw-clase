<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log In</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/formularis.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/2a59fbfff2.js" crossorigin="anonymous"></script>
</head>

<body class="login">
    <div class="login-container d-flex align-items-center justify-content-center vh-100">
        <div class="container w-75">
            <div class="row box-shadow d-flex justify-content-center">
                <div class="col-6 bg-body px-5 pb-5 rounded shadow">
                    <!-- Logo -->
                    <div class="d-flex text-end close-container mb-5">
                        <a id="close-btn" href="<?= base_url() ?>"><i class="fa-regular fa-circle-xmark fa-xl text-dark"></i></a>
                    </div>

                    <div class="d-flex  align-items-center">
                        <a href="<?= base_url() ?>" class="text-decoration-none d-flex text-dark align-items-center">
                            <img class="me-2" src="<?= base_url('assets/img/logo.png') ?>" alt="" width="48" />
                            <div id="text">
                                <div id="effect" class="d-flex">
                                    <span class="fs-4">Coding Souls</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <h3 class="fw-bold text-center py-4">Benvingut rei, entra al nostre regne</h3>
                    <?= service('validation')->listErrors(); ?>
                    <!-- Formulari login -->
                    <form action="<?= base_url('login') ?>" method="POST">
                        <?= csrf_field(); ?>
                        <div class="row mb-3">
                            <label for="nick" class="mb-1">Email</label>
                            <input type="email" class="form-control" name="email" id="nick" value="<?= old('email') ?>" required />
                            <?php if (service('validation')->getError('email')) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= service('validation')->getError('email') ?>
                                </div>
                            <?php } //endif error email
                            ?>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="mb-1">Contrasenya</label>
                            <input type="password" name="password" class="form-control" id="password" value="<?= old('password') ?>" required />
                            <?php if (service('validation')->getError('password')) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= service('validation')->getError('password') ?>
                                </div>
                            <?php } //endif error email
                            ?>
                        </div>
                        <div class="mb-3 form-check">
                            <label for="remember" class="form-label">Recorda el nom d'usuari</label>
                            <input type="checkbox" class="form-check-input" id="remember" name="rememberMe" />
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Inicia sessió</button>
                        <?php if (session()->getFlashdata('error')) { ?>
                            <div class="alert alert-danger mt-2" role="alert">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php } //endif error login
                        ?>
                    </form>

                    <div class="mt-3">
                        <span>No estas registrat? <a href="<?= base_url('register') ?>">Registra't</a></span><br />
                        <span>T'has oblidat de la contrasenya? <a href="#">Recuperar la contrasenya</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>