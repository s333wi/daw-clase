<?php $pager->setSurroundCount(2) ?>

<nav>
    <ul class="pagination">
        <?php if ($pager->hasPreviousPage()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst() ?>">&lt;&lt;</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPreviousPage() ?>">&lt;</a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li <?= $link['active'] ? 'class="page-item active"' : 'class="page-item"' ?>>
                <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNextPage()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNextPage() ?>">&gt;</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast() ?>">&gt;&gt;</a>
            </li>
        <?php endif ?>
    </ul>
</nav>