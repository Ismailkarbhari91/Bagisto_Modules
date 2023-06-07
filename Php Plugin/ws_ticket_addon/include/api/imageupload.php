<?php
$file = $_FILES['file'];
$name = $file['name'];
$path = "/uploads/" . basename($name);
if (move_uploaded_file($file['tmp_name'], $path)) {
    echo " Move succeed";
} else {
 echo " Move failed. Possible duplicate?";
}