<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Coding Souls Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/estil.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/2a59fbfff2.js" crossorigin="anonymous"></script>
</head>

<body>

    <!-- SECCIO DEL HEADER -->
    <div class="container-fluid header p-0">
        <header class="d-flex flex-wrap justify-content-center p-2 align-items-center w-100 bg-body">
            <div class="d-flex align-items-center mb-md-0 me-md-auto text-dark text-decoration-none">
                <a href="index.php">
                    <img alt="logo" class="logotip" height="50px" src="<?= base_url('assets/img/logo.png') ?>">
                </a>
                <div id="text">
                    <div id="effect" class="d-flex">
                        <span class="ms-1 fs-4">Coding Souls</span>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <div class="container-fluid d-flex mt-5 mb-4 justify-content-around align-items-start">
        <div class="col-9 bg-white rounded p-4">
            <h2 class="text-uppercase text-dark"><span class="fw-bold">Benvingut</span> al portal genèric</h2>
        </div>
        <div class="col-2 bg-white rounded text-dark p-4">
            <div class="row">
                <div class="col">
                    <p><span class="fw-bold text-uppercase">Usuari</span>: <?= session()->get('name') ?></p>
                </div>
            </div>

            <div class="row">
                <div class="row border-bottom text-center">
                    <div class="col">
                        <p class="text-secondary fw-bold text-uppercase">Administració</p>
                    </div>
                </div>
                <ul class="nav d-flex flex-column ps-2">
                    <li class="nav-item mt-1">
                        <a href="<?= base_url('users/dashboard')?>" class="text-dark">Gestió usuaris</a>
                    </li>
                    <li class="nav-item mt-1">
                        <a href="<?= base_url('news/dashboard') ?>" class="text-dark">Gestió notícies</a>
                    </li>
                    <li class="nav-item mt-1">
                        <a href="<?= base_url('roles/dashboard')?>" class="text-dark">Gestió rols</a>
                    </li>
                </ul>
            </div>
            <div class="row mt-2">
                <ul class="nav d-flex flex-column ps-2">
                    <li class="nav-item">
                        <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100">Desconnectar</a>
                    </li>
                </ul>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>