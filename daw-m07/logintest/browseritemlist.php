<?php
if ($dh = opendir($ruta_user)) {
    echo '<ul>';
    while (($file = readdir($dh)) !== false) {
        if (is_dir($ruta_user . "\\" . $file)) {
            //Creacio dels directoris amb les seves icones
            echo "<li><img src='./icons/folder.png' alt='folder' width='15'>
            <span><a href='browser.php?link=" . $link_user_sanitize . '\\' . $file . "'>" . $file . "</a></span>
            <a href='?link=" . $link_user_sanitize . '\\' . $file . '&delete=1' . "'>
            <img src='./icons/fdelete.png' alt='delete' width='15'>
            </a>
            </li>";
        } else {
            //Creacio dels fitxers amb les seves icones
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
