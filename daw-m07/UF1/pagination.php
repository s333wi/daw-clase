<?php
$total_pages = 5;
$pageno = isset($_GET['pageno']) ? $_GET['pageno'] : 1;
$msg = '<h3>';
$msg .= ($pageno <= 0 || $pageno > $total_pages) ? 'ERROR! Fora del rang</h3>' : 'Estas en la pagina ' . $pageno . '</h3>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            text-align: center;
        }

        li {
            display: inline-flex;
            margin: 5px;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginacio</title>
</head>

<body>
    <?= $msg ?>
    <div>
        <ul class="pages">
            <?php
            for ($pag = 1; $pag <= $total_pages; $pag++) {
                echo '<li>
            <a href = "?pageno=' . $pag . '">Pagina ' . $pag . '</a>
            </li>';
            }
            ?>
        </ul>
    </div>
    <div>

        <ul class="pagination">
            <li>
                <a href="?pageno=1">Primera</a>
            </li>

            <li class="<?php if ($pageno <= 1) {
                            echo 'disabled';
                        } ?>">
                <a href="<?php if ($pageno <= 1) {
                                echo '#';
                            } else {
                                echo "?pageno=" . ($pageno - 1);
                            } ?>">Anterior
                </a>
            </li>
            <li class="<?php if ($pageno >= $total_pages) {
                            echo 'disabled';
                        } ?>">
                <a href="<?php if ($pageno >= $total_pages) {
                                echo '#';
                            } else {
                                echo "?pageno=" . ($pageno + 1);
                            } ?>">Seguent
                </a>
            </li>
            <li>
                <a href="?pageno=<?= $total_pages ?>">Ultima</a>
            </li>
        </ul>
    </div>
</body>

</html>