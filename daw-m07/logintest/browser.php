<?php
session_start();
//Links necessaris per fer les operacions del browser
$ruta_root = realpath('./dades');
$link_user = !empty($_GET['link']) ? ($_GET["link"]) : '';
$ruta_user = realpath($ruta_root . "\\" . $link_user);
$link_user_sanitize = str_replace($ruta_root, '', $ruta_user);
$ext = pathinfo($ruta_user, PATHINFO_EXTENSION);
include 'browserFunctions.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if (empty($_SESSION['username'])) {
    header("Location:index.php");
}

echo 'Var ruta_root: ' . $ruta_root . '<br>';
echo 'Var ruta_user: ' . $ruta_user . '<br>';
echo 'Var link_user: ' . $link_user . '<br>';
echo 'Var link_user_sanitize: ' . $link_user_sanitize . '<br>';
echo 'Var ext: ' . $ext . '<br>';

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
    if (!empty($ext) && !empty($_GET['view'])) {
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
        $link_user_sanitize = str_replace("/" . $filename, "", $link_user_sanitize);
        echo "<a href='browser.php?link=" . $link_user_sanitize . '\\..' . "'>GO BACK</a>";
    }

    if (is_dir($ruta_user)) {
        if ($dh = opendir($ruta_user)) {
            echo '<ul>';
            while (($file = readdir($dh)) !== false) {
                //echo $ruta_user . "" . $file;
                if (is_dir($ruta_user . "/" . $file)) {
                    echo "<li><img src='./icons/folder.png' alt='folder' width='15'>
                    <span><a href='browser.php?link=" . $link_user_sanitize . '/' . $file . "'>" . $file . "</a></span>
                    <a href='?link=" . $link_user_sanitize . '\\' . $file . '&delete=1' . "'>
                    <img src='./icons/fdelete.png' alt='delete' width='15'>
                    </a>
                    </li>";
                } else {
                    echo "<li><img src='./icons/file.png' alt='file' width='15'><span>" . $file . "</span>
                        <a href='?link=" . $link_user_sanitize . '\\' . $file . '&download=1' . "'>
                        <img src='./icons/down.png' alt='download' width='15'>
                        <a href='?link=" . $link_user_sanitize . '\\' . $file . '&view=1' . "'>
                        <img src='./icons/fview.png' alt='download' width='15'></a>
                        <a href='?link=" . $link_user_sanitize . '\\' . $file . '&delete=1' . "'>
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
    <form action="./browser.php" method="post">
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
            if (is_dir($ruta_user)) {
                $objects = scandir($ruta_user);
                if (strpos($ruta_user, '/', -1) === false) {
                    $ruta_user = $ruta_user . '/';
                }
                foreach ($objects as $object) {
                    echo ($ruta_root . "\\" . $object).'<br />';
                    if ($object != "." && $object != "..") {
                        if (filetype($ruta_root . "\\" . $object) == "dir" && $ruta_user !== $ruta_root . "\\" . $object) {
                            echo '<option value="' . $ruta_root . "\\" . $object . '">' . $object . '</option>';
                        }
                    }
                }
                reset($objects);
            }
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
</body>

</html>