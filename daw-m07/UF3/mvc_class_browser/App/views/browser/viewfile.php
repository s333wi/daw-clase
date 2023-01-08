<?php
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
 echo "<a href='index.php?action=browser&link=" . $link_user_sanitize . '\\..' . "'>GO BACK</a>";
