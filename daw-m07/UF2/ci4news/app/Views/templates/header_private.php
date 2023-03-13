<!-- SECCIO DEL HEADER -->
<div class="container-fluid header p-0">
    <header class="d-flex flex-wrap justify-content-center p-3 mb-4 align-items-center w-100 bg-body">
        <div class="d-flex align-items-center mb-md-0 me-md-auto text-dark text-decoration-none">
            <a href="<?= base_url() ?>">
                <img alt="logo" class="logotip" height="50px" src="<?= base_url('assets/img/logo.png') ?>">
            </a>
            <div id="text">
                <div id="effect" class="d-flex">
                    <span class="ms-1 fs-4">Coding Souls</span>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills text-decoration-none">
            <li class="nav-item"><a href="<?= base_url() ?>" class="nav-link active">Home</a></li>
            <li class="nav-item"><a href="<?= base_url('create') ?>" class="nav-link text-success">Afegir noticia <i class="fa-solid fa-plus-large"></i></a></li>
            <li class="nav-item"><a href="<?= base_url('login')?>" class="nav-link">Log In</a></li>
        </ul>
    </header>
</div>