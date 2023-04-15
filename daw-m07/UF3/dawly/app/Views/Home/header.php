<?php helper('auth') ?>
<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top shadow">
    <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>"><img id="logoDawly" src="<?= base_url('assets/img/logo.png') ?>" alt="Logo web" srcset="">
        <span>DAWLY</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url() ?>"><i class="bi bi-house-door-fill"></i><?= lang('Auth.home') ?></a>
            </li>
            <?php if (logged_in()) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('user/dashboard') ?>"><i class="bi bi-person-fill"></i>Usuaris</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('link/dashboard') ?>"><i class="bi bi-link-45deg"></i>Enllaços</a>
                </li>
            <?php } ?>
        </ul>
        <ul class="navbar-nav">
            <?php if (!logged_in()) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= route_to('login') ?>"><i class="bi bi-door-closed-fill text-success"></i>Log in</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= route_to('register') ?>"><i class="bi bi-key-fill"></i>Register</a>
                </li>
            <?php } else { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= route_to('logout') ?>"><i class="bi bi-door-open-fill text-danger"></i>Log out</a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <!-- Add at the end of the navbar login and register buttons -->


</nav>