<?= $this->extend('layouts/layout_news') ?>
<?= $this->section('news_content') ?>
<?php
?>
<div class="row px-5 justify-content-center">
    <table class="table table-striped table-hover bg-white rounded">
        <thead>
            <tr>
                <th scope="col"><a class="text-decoration-none text-reset" href="<?= base_url('dashboard') ?>?order=id&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">ID</a></th>
                <th scope="col"><a class="text-decoration-none text-reset" href="<?= base_url('dashboard') ?>?order=title&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">Titol</a></th>
                <th scope="col"><a class="text-decoration-none text-reset" href="<?= base_url('dashboard') ?>?order=body&so=<?= $sort ?>&page=<?= $pager->getCurrentPage() ?>">Body</a></th>
                <th scope="col">Data</th>
                <th scope="col">Accions</th>
            </tr>
        </thead>
        <tbody class="p-3">
            <?php if (!empty($info_news)) : ?>
                <?php foreach ($info_news as $news) : ?>
                    <tr class="align-middle m-5">
                        <td><?= $news['id'] ?></td>
                        <td><?= $news['title'] ?></td>
                        <td><?= $news['body'] ?></td>
                        <td><?= date('d/m/Y', strtotime($news['data_pub'])) ?></td>
                        <td>
                            <div class="row g-2">
                                <div class="col">
                                    <a href="update/<?= $news['slug'] ?>" class="btn btn-outline-success w-100">Editar</a>
                                </div>
                                <div class="col">
                                    <a href="delete/<?= $news['id'] ?>" class="btn btn-outline-danger w-100">Eliminar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">No hi ha noticies disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?= $pager->links('default', 'custom_paginator') ?>
</div>
<?= $this->endSection() ?>