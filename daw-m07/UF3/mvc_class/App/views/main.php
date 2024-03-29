<?php
/* Block time: 20221207 15:47:50*/
defined('MVC_APP') or die('Access denied');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Coding Souls</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="App/views/css/estil.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/2a59fbfff2.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- SECCIO DEL HEADER -->
    <div class="container-fluid header p-0">
        <header class="d-flex flex-wrap justify-content-center p-3 mb-4 align-items-center w-100 bg-body">
            <div class="d-flex align-items-center mb-md-0 me-md-auto text-dark text-decoration-none">
                <a href="#">
                    <img alt="logo" class="logotip" height="50px" src="App/views/images/logo.png">
                </a>
                <div id="text">
                    <div id="effect" class="d-flex">
                        <span class="ms-1 fs-4">Coding Souls</span>
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills text-decoration-none">
                <li class="nav-item"><a href="index.php" class="nav-link active">Home</a></li>
                <li class="nav-item"><a href="index.php?action=login" class="nav-link">Accedeix</a></li>
                <li class="nav-item"><a href="index.php?action=register" class="nav-link">Registrar-se</a></li>
                <li class="nav-item"><a href="https://reskyt.com/ca/educacio/iescaparrella/formulari/t-3764" class="nav-link">Contacta'ns</a></li>
            </ul>
        </header>
    </div>


    <!-- ALERTA DE REGISTRE -->
    <?php if (!empty($_GET['register'])) : ?>
        <div class="toast top-0 align-items-center border-0 <?= $_GET['register'] == 1 ? 'text-bg-success' : 'text-bg-warning' ?> mb-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
            <div class="d-flex">
                <div class="toast-body">
                    <?= $_GET['register'] == 1  ? 'T\'has registrat correctament!' : 'Hi ha hagut un error, torna a intentar-ho mes tard' ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- SECCIO DE LES NOTICIES -->
    <div class="container my-5 rounded">
        <div class="row justify-content-around">
            <div class="col-12 news p-5 bg-body text-dark">
                <?php if (!empty($info_news)) : ?>
                    <?php $counter = 0; ?>
                    <div class="row mb-3 justify-content-center gx-2">
                        <?php foreach ($info_news as $news) : ?>
                            <div class="col-4 bg-light text-dark p-0 border-0 ">
                                <div class="card m-2">
                                    <div class="card-body p-0 border-0 bg-secondary text-dark d-flex flex-column">
                                        <h3 class="card-title text-center bg-dark text-light p-2"><?php echo $news['titol'] ?></h3>
                                        <p class="card-text px-2 py-4 text-light"><?php echo $news['descripcio'] ?></p>
                                    </div>
                                    <div class="card-footer bg-dark text-light text-end">
                                        <span><?= date('d/m/Y', strtotime($news['data'])) ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php $counter++; ?>
                            <?php if ($counter % 3 == 0) : ?>
                    </div>
                    <div class="row mb-3 gx-2 justify-content-center">
                    <?php endif; ?>
                <?php endforeach; ?>
                    </div>
                    <?php else:?>
                        <div class="alert alert-warning" role="alert">
                            No hi ha noticies disponibles
                        </div>
                <?php endif; ?>
            </div>
        </div>
    </div>



    <!-- SECCIO DEL FOOTER -->
    <div class="container-fluid mt-auto footer bottom">
        <div class="row p-5 bg-body text-dark">
            <div class="col-xs-12 col-md-6 col-lg-3 d-flex flex-column">
                <img src="App/views/images/logo-capa.png" style="width:300px;" alt="logo_capa">
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3 d-flex flex-column">
                <p class="h5">Xarxes socials</p>
                <ul class="footer-nav nav d-flex flex-column">
                    <li class='nav-item '>
                        <a class="nav-link" href="https://www.facebook.com/inscaparrella/">
                            <i class="fa fa-facebook-square menus-fa-2x" aria-hidden="true" style="color: rgb(121, 121, 121);"></i>
                            Facebook
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link" href="https://twitter.com/inscaparrella?lang=en">
                            <i class="fa fa-twitter-square menus-fa-2x" aria-hidden="true" style="color: rgb(121, 121, 121);"></i>
                            Twitter
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link" href="https://www.youtube.com/user/InstitutCaparrella/videos">
                            <i class="fa fa-youtube-play menus-fa-2x" aria-hidden="true" style="color: rgb(121, 121, 121);"></i>
                            Youtube
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link" href="https://www.instagram.com/inscaparrella/">
                            <i class="fa fa-instagram menus-fa-2x" aria-hidden="true" style="color: rgb(121, 121, 121);"></i>
                            Instagram
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-3 d-flex flex-column">
                <p class="h5">Centre</p>
                <ul class="footer-nav nav d-flex flex-column">
                    <li class='nav-item '>
                        <a class="nav-link">
                            Comunicació Centre - Família
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link">
                            Calendari i llibres de text curs 2022-2023
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link">
                            Racó dels pares
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link">
                            AMPA
                        </a>
                    </li>
                </ul>

            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <p class="h5">Contacte</p>
                <ul class="footer-nav nav d-flex flex-column">
                    <li class='nav-item widget-title'>
                        <a class="nav-link" href="#">
                            IES Caparrella
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link">
                            Partida Caparrella 98
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link">
                            25192 Lleida
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link" href="tel:973288180">
                            Tel: 973 28 81 80
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link">
                            Fax: 973280195
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link" href="mailto:iescaparrella@iescaparrella.cat">
                            iescaparrella@iescaparrella.cat
                        </a>
                    </li>
                    <li class='nav-item '>
                        <a class="nav-link" href="https://reskyt.com/ca/educacio/iescaparrella/formulari/t-3764">
                            Contacta&#039;ns
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
        let toast = document.querySelector('.toast');
        if (toast) {
            let toastAlert = new bootstrap.Toast(toast);
            toastAlert.show();
        }
    </script>
</body>

</html>