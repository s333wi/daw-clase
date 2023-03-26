<?= $this->extend('layouts/layout_news') ?>
<?= $this->section('news_content') ?>
<?php
?>
<div class="row px-5 justify-content-center">
    <table class="table table-striped table-hover bg-white rounded">
        <thead>
            <tr>
                <th scope="col"><a class="text-decoration-none text-reset" href="?order=id&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">ID</a></th>
                <th scope="col"><a class="text-decoration-none text-reset" href="?order=name&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">Rol</a></th>
                <th scope="col"><a class="text-decoration-none text-reset" href="?order=code&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">Codi</a></th>
                <th scope="col"><a class="text-decoration-none text-reset" href="?order=description&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">Descricpio</a></th>
                <th scope="col">Data</th>
                <th scope="col">Accions</th>
            </tr>
        </thead>
        <tbody class="p-3">
            <?php if (!empty($info_roles)) : ?>
                <?php foreach ($info_roles as $roles) : ?>
                    <tr class="align-middle m-5">
                        <td><?= $roles['id'] ?></td>
                        <td><?= $roles['name'] ?></td>
                        <td><?= $roles['code'] ?></td>
                        <td><?= $roles['description'] ?></td>
                        <td>
                            <div class="row g-2">
                                <div class="col">
                                    <a href="update/<?= $roles['id'] ?>" class="btn btn-outline-success w-100">Editar</a>
                                </div>
                                <div class="col">
                                    <a href="delete/<?= $roles['id'] ?>" class="btn btn-outline-danger w-100">Eliminar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">No hi ha rols disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?= $pager->links('default', 'custom_paginator') ?>
</div>
<?= $this->endSection() ?>