<?php
//Links necessaris per fer les operacions del browser
$ruta_root = realpath('./dades');
$link_user = !empty($_GET['link']) ? ($_GET["link"]) : '';
$ruta_user = realpath($ruta_root . "\\" . $link_user);
$link_user_sanitize = str_replace($ruta_root, '', $ruta_user);
$ext = pathinfo($ruta_user, PATHINFO_EXTENSION);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Funcio recursiva per borrar directori
function dltDir($dir)
{
    var_dump(is_dir($dir));
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                if (filetype($dir . "\\" . $file) == "dir") dltDir($dir . "\\" . $file);
                else unlink($dir . "\\" . $file);
            }
        }
        rmdir($dir);
    } elseif (is_file($dir)) {
        unlink($dir);
    }
}

//Funcio recursiva per copiar arxius/carpetes, si es vol fer move al final es borra el dir
function copyDir($src, $dst)
{
    echo 'Source:' . $src . '<br>';
    echo 'Dest:' . $dst . '<br>';
    $file = basename($src);
    if (is_dir($src)) {
        // 
        $dir = opendir($src);
        //Si no existeix creo la carpeta i em guardo la ruta per guardar els arxius adins
        if (!file_exists($dst)) mkdir($dst);
        //Llegim carpetes i subcarpetes
        while ($file = readdir($dir)) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '\\' . $file)) {
                    //Cridem a la funcio recursiva per crear buscar totes les subcarpetes i crear-les
                    copyDir($src . '\\' . $file, $dst . '\\' . $file);
                } else {
                    //Si no es una carpeta simplement copiem l'arxiu en el directori que estem
                    copy($src . '\\' . $file, $dst . '\\' . $file);
                }
            }
        }
        closedir($dir);
        //Si la crida es fa nomes contra un arxiu nomes s'ha de copiar
    } else copy($src, $dst . '\\' . $file);
}

//Funcio per llistar directoris als quals s'envien l'arxiu/carpeta
function listDir($ruta, $root)
{
    $dirs = scandir($ruta);
    foreach ($dirs as $dir) {
        $subdir = str_replace($root . '\\', '', $ruta . '\\' . $dir);
        if (is_dir($ruta . '\\' . $dir) && ($dir != '.') && ($dir != '..')) {
            echo '<option value="' . $ruta . '\\' . $dir . '">' . $subdir . '</option>';
            echo $subdir;
            //Crido a la recursivitat i sempre passo el root per obtenir els subdirectoris
            listDir($ruta . '\\' . $dir, $root);
        }
        reset($dirs);
    }
}

//Tractament de les variables que venen per $_GET
//Metode de descarrega
if (!empty($_GET['download'])) {
    $file_name = $ruta_user;
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file_name)) . ' GMT');
    header('Cache-Control: private', false);
    header('Content-Type: application/force-download');
    header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
    header('Content-Length: ' . filesize($file_name));
    header('Connection: close');
    readfile($file_name);
    exit;
    die();

    //Metode d'esborrament
} elseif (!empty($_GET['delete'])) {
    dltDir($ruta_user);
    header("Location: ./browser.php?link=" . $ruta_user . "\\..");
    die;
}

//Tractament de la accio segons el tipus
if (isset($_POST['actionFile'])) {
    $src = $_POST['mainFile'];
    $dest = $_POST['destFolder'];
    if ($src == $dest) {
        echo 'No es pot copiar a la mateixa carpeta<br>';
        echo '<a href="./browser.php">Go back</a>';
        die;
    }
    //Si es un dir primer el creo per poder crear les subcarpetes
    if (is_dir($src)) {
        $dir = basename($src);
        mkdir($dest . '\\' . $dir);
        $dest = $dest . '\\' . $dir;
    }
    copyDir($src, $dest);
    //Si l'accio es fer un move elimino el arxiu/directori
    if ($_POST['actionFile'] == 'actionMove') {
        dltDir($src);
    }
    header("Location:./browser.php");
    die;
}

//Tractament de la creacio segons el tipus
if (!empty($_POST['createFileDir'])) {
    if ($_POST['createFileDir'] == 'createFile') {
        $file = fopen($ruta_user . '\\' . $_POST['nameFile'], 'x');
        fclose($file);
    } elseif ($_POST['createFileDir'] == 'createDir') {
        mkdir($ruta_user . '\\' . $_POST['nameFile']);
    }
}
