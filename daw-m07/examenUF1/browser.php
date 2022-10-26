<?php
session_start();
$current_user = $_SESSION['username'];
//Primer extrec el rol del usuari actual per controlar la vista de la carpeta private
$users = unserialize(file_get_contents('users.php'));
$userRol = $users[$current_user]['rol'];

if (empty($_SESSION['username'])) {
    header("Location:index.php");
}
//Obtinc totes les rutes necessaries per llistar tots els arxius
$ruta_root = realpath('./dades');
$link_user = !empty($_GET['link']) ? ($_GET["link"]) : '';
$ruta_user = realpath($ruta_root . "/" . $link_user);
$link_user_sanitize = str_replace($ruta_root, '', $ruta_user);
$ext = pathinfo($ruta_user, PATHINFO_EXTENSION);

if (strpos($ruta_user, $ruta_root) === false) {
    header("Location:./browser.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <h1>BROWSER</h1>

    <?php
    if (!empty($ext) && empty($_GET['download']) && empty($_GET['delete'])) {
        $ruta_file = $ruta_root . "" . $link_user;
        $myfile = fopen($ruta_file, "r") or die("Can not open file");
        echo '<pre>';
        if (filesize($ruta_file) <= 0) {
            echo 'Empty file';
        } else {
            echo fread($myfile, filesize($ruta_file));
        }
        echo '</pre>';
        fclose($myfile);
        $filename = basename($ruta_file);
        echo 'Var filename: ' . $filename .  '<br>';
        $link_user_sanitize = str_replace("/" . $filename, "", $link_user_sanitize);
        echo "<a href='browser.php?link=" . $link_user_sanitize . "'>GO BACK</a>";
    }

    if (is_dir($ruta_user)) {
        if ($dh = opendir($ruta_user)) {
            echo '<ul>';
            while (($file = readdir($dh)) !== false) {
                if (is_dir($ruta_user . "/" . $file)) {
                    if (!($file === 'private' && $userRol != 'admin')) {
                        //Control de la vista de la carpeta private, miro file a file buscant private i quan el trobo miro el rol del user
                        echo "<li><img src='./icons/folder.png' alt='folder' width='15'>
                    <span><a href='browser.php?link=" . $link_user_sanitize . '/' . $file . "'>" . $file . "</a></span>
                    <a href='?link=" . $link_user_sanitize . '/' . $file . '&delete=1' . "'>
                    <img src='./icons/fdelete.png' alt='delete' width='15'>
                    </a>
                    </li>";
                    }
                } else {
                    echo "<li><img src='./icons/file.png' alt='file' width='15'><span>" . $file . "</span>
                        <a href='?link=" . $link_user_sanitize . '/' . $file . '&download=1' . "'>
                        <img src='./icons/down.png' alt='download' width='15'>
                        <a href='?link=" . $link_user_sanitize . '/' . $file . "'>
                        <img src='./icons/fview.png' alt='download' width='15'></a>
                        <a href='?link=" . $link_user_sanitize . '/' . $file . '&delete=1' . "'>
                        <img src='./icons/fdelete.png' alt='delete' width='15'>
                        </a>
                        </li>";
                }
            }
            echo '</ul>';
            closedir($dh);
        }
    }
    ?>

</body>

</html>