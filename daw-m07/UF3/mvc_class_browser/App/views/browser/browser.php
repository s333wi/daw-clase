<?php
//BROWSER PHP by @s333wi

if (empty($_SESSION['username'])) {
    header("Location:index.php");
}
include_once 'browserFunctions.php';

if (strpos($ruta_user, $ruta_root) === false) {
    header("Location:index.php?action=browser");
}

//Vario entre scandir i readdir ja que quan vaig començar estava utilitzant el readdir 
//pero les funcionalitats mes noves ja començo a utilitzar el scandir
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <title>Browser</title>
    <style>
        img {
            margin-right: 5px;
        }

        ul li {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        span {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container-fluid d-flex flex-column align-items-center">
        <h1>BROWSER</h1>

        <?php
        //Funcio per veure els arxius
        if (!empty($ext) && !empty($_GET['view'])) {
            include_once 'viewfile.php';
        }

        //Llistat de tots els arxius i directoris
        if (is_dir($ruta_user)) {
            include_once 'browseritemlist.php';
        }
        ?>

        <!-- Formulari per copiar o moure els arxius/directoris -->
        <form action="./browser.php?link=<?= $link_user_sanitize ?>" method="post">
            <label for="mainFile">From: </label>
            <select name="mainFile" id="mainFile">
                <?php
                if (is_dir($ruta_user)) {
                    if ($dh = opendir($ruta_user)) {
                        while (($file = readdir($dh)) !== false) {
                            if ($file != '.' && $file != '..') {
                                echo '<option value="' . $ruta_user . '\\' . $file . '">' . $file . '</option>';
                            }
                        }
                        closedir($dh);
                    }
                }
                ?>
            </select>
            <label for="destFolder">To:</label>
            <select name="destFolder" id="destFolder">
                <?php
                //Fico la ruta root 2 vegades ja que les funcions no poden accedir a les
                //variables que ja tinc creades al principi
                listDir($ruta_user, $ruta_root);
                ?>
                <option value="<?= $ruta_root ?>">root</option>
            </select>
            <label for="actionFile">Action: </label>
            <select name="actionFile" id="actionFile">
                <option value="actionCopy">Copy</option>
                <option value="actionMove">Move</option>
            </select>
            <input type="submit" value="Submit">
        </form>

        <!-- Formulari per la creacio d'arxius/directoris -->
        <form action="./browser.php?link=<?= $link_user_sanitize ?>" method="post">
            <label for="inpNameFile">Create file/dir</label>
            <input type="text" name="nameFile" id="inpNameFile">
            <label for="inpTypeFile">Type:</label>
            <select name="createFileDir" id="inpTypeFile">
                <option value="createFile">File</option>
                <option value="createDir">Directory</option>
            </select>
            <input type="submit" value="Submit">
        </form>
        <a href="index.php?action=dashboard" class="btn btn-primary mt-2">Torna enrere</a>
    </div>

</body>

</html>