<?php
if ($dh = opendir($ruta_user)) {
    echo '<ul>';
    while (($file = readdir($dh)) !== false) {
        if (is_dir($ruta_user . "\\" . $file)) {
            //Creacio dels directoris amb les seves icones
            echo "<li>
            <img src='App/views/browser/icons/folder.png' alt='folder' width='15'>
            <span><a href='index.php?action=browser&link=" . $link_user_sanitize . '\\' . $file . "'>" . $file . "</a></span>";

            if ($file != '.' && $file != '..') {
                echo "
                <a href='index.php?action=browser&link=" . $link_user_sanitize . '\\' . $file . '&delete=1' . "'>
                    <img src='App/views/browser/icons/fdelete.png' alt='delete' width='15'>
                </a>
                <a href='index.php?action=browser&link=" . $link_user_sanitize . '\\' . $file . '&zip=1' . "'>
                    <img src='App/views/browser/icons/zip.png' alt='zip' width='15'>
                </a>";
            }
            echo "</li>";
        } else {
            //Creacio dels fitxers amb les seves icones
            echo "<li>
            <img src='App/views/browser/icons/file.png' alt='file' width='15'><span>" . $file . "</span>
                <a href='index.php?action=browser&link=" . $link_user_sanitize . '\\' . $file . '&download=1' . "'>
                <img src='App/views/browser/icons/down.png' alt='download' width='15'>
                <a href='index.php?action=browser&link=" . $link_user_sanitize . '\\' . $file . '&view=1' . "'>
                <img src='App/views/browser/icons/fview.png' alt='download' width='15'></a>
                <a href='index.php?action=browser&link=" . $link_user_sanitize . '\\' . $file . '&zip=1' . "'>
                <img src='App/views/browser/icons/zip.png' alt='zip' width='15'>
                </a>
                <a href='index.php?action=browser&link=" . $link_user_sanitize . '\\' . $file . '&delete=1' . "'>
                <img src='App/views/browser/icons/fdelete.png' alt='delete' width='15'>
                </a>
                </li>";
        }
    }
    echo '</ul>';
    closedir($dh);
}
