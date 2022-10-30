<?php

//Funcio recursiva per borrar directori
function dltDir($dir)
{
    echo 'Var dir: ' . $dir . '<br>';
    var_dump(is_dir($dir));
    if (is_dir($dir)) {
        $objects = scandir($dir);
        print_r($objects);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "\\" . $object) == "dir")
                    dltDir($dir . "\\" . $object);
                else unlink($dir . "\\" . $object);
            }
        }
        reset($objects);
        rmdir($dir);
    } elseif (is_file($dir)) {
        unlink($dir);
    }
}
function copyDir($src, $dst)
{   
    echo $src.'<br>';
    echo $dst.'<br>';
    $file = basename($src);
    if (is_dir($src)) {
        // open the source directory
        $dir = opendir($src);

        // Make the destination directory if not exist
        @mkdir($dst.'\\'.$file);

        // Loop through the files in source directory
        while ($file = readdir($dir)) {

            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {

                    // Recursively calling custom copy function
                    // for sub directory
                    copyDir($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    } else {
        copy($src, $dst.'\\'.$file);
    }

}

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
} elseif (!empty($_GET['delete'])) {
    dltDir($ruta_user);
    header("Location: " . $ruta_user . "\..");
}

if (isset($_POST['actionFile'])) {
    echo 'me ha llegado el post';
    $src = $_POST['mainFile'];
    $dest = $_POST['destFolder'];
    copyDir($src, $dest);
    if ($_POST['actionFile'] == 'actionMove') {
        echo 'se ha borrado';
        die();
        dltDir($src);
    }
}
