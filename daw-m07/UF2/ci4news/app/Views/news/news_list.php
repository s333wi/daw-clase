<?= $this->extend('layouts/news') ?>

<?= $this->section('news_content') ?>


<div class="container row justify-content-around">
    <?php if (!empty($info_news)) { ?>
        <?php $counter = 0; ?>
        <div class="row row-cols-3 mb-3 justify-content-center gx-2">
            <?php foreach ($info_news as $news) { ?>
                <div class="col-4 bg-light text-dark p-0 border-0 ">
                    <div class="card m-2 h-100">
                        <div class="card-header">
                            <h3 class="text-center bg-dark text-light p-2"><?php echo $news['title'] ?></h3>
                        </div>
                        <div class="card-body p-0 border-0 bg-secondary text-dark d-flex flex-column">
                            <p class="card-text px-2 py-4 text-light"><?php echo $news['body'] ?></p>
                        </div>
                        <div class="card-footer bg-dark text-light d-flex justify-content-around">
                            <a href="index.php?action=view_news&id=<?= $news['slug'] ?>" class="text-decoration-none text-danger">Veure mes...</a>
                            <span><?= date('d/m/Y', strtotime($news['data_pub'])) ?></span>
                        </div>
                    </div>
                </div>
                <?php $counter++; ?>
                <?php if ($counter % 3 == 0) { ?>
        </div>
        <div class="row mb-3 gx-2 justify-content-center">
        <?php } //endif fill 
        ?>
    <?php } //endforeach
    ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning" role="alert">
            No hi ha noticies disponibles
        </div>
    <?php } //endif pare
    ?>
</div>

<?= $this->endSection() ?>