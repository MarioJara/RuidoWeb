<?php

function log_string($text) {
    $file = 'upload.log';
    // Open the file to get existing content
    $current = file_get_contents($file);
    // Append a new person to the file
    $current .= "\n" . $text;
    // Write the contents back to the file
    file_put_contents($file, $current);
}

 // Directory where uploaded images are saved
 $dirname = "uploads/"; 
 // If uploading file
 if ($_FILES) {
    log_string(json_encode($_FILES));
    if(!file_exists($dirname)) {
        mkdir ($dirname, 0777, true);
    }
    log_string(json_encode($_FILES["blank_wav"]["tmp_name"]));
    log_string(json_encode($_FILES["blank_wav"]["name"]));
    //move_uploaded_file($_FILES["blank_wav"]["tmp_name"], $dirname.$_FILES["blank_wav"]["name"]);
    move_uploaded_file($_FILES["blank_wav"]["tmp_name"], "/var/www/html/prexor/uploads/".$_FILES["blank_wav"]["name"]);
 } else {
     log_string("No FILES");
 }
