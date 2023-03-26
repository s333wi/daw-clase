<?= $this->extend('layouts/layout_news') ?>
<?= $this->section('news_content') ?>
<?php

?>
<div class="row px-5 justify-content-center">
    <table class="table table-striped table-hover bg-white rounded">
        <thead>
            <tr>
                <th scope="col"><a class="text-decoration-none text-reset" href="<?= base_url('dashboard') ?>?order=id&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">ID</a></th>
                <th scope="col"><a class="text-decoration-none text-reset" href="<?= base_url('dashboard') ?>?order=name&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">Nom</a></th>
                <th scope="col"><a class="text-decoration-none text-reset" href="<?= base_url('dashboard') ?>?order=email&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">Email</a></th>
                <th scope="col"><a class="text-decoration-none text-reset" href="<?= base_url('dashboard') ?>?order=role_code&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">Rol</a></th>
                <th scope="col">Data</th>
                <th scope="col">Accions</th>
            </tr>
        </thead>
        <tbody class="p-3">
            <?php if (!empty($info_users)) { ?>
                <?php foreach ($info_users as $user) { ?>
                    <?php if ($user['id'] == $_SESSION['id']) continue; ?>
                    <tr class="align-middle m-5">
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role_code'] ?></td>
                        <td>
                            <div class="row g-2">
                                <div class="col">
                                    <a href="update/<?= $user['id'] ?>" class="btn btn-outline-success w-100">Editar</a>
                                </div>
                                <div class="col">
                                    <a href="delete/<?= $user['id'] ?>" class="btn btn-outline-danger w-100">Eliminar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5" class="text-center">No hi ha usuaris disponibles</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?= $pager->links('default', 'custom_paginator') ?>
</div>
<?= $this->endSection() ?>