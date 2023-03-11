<?php

$uid = filter_input(INPUT_POST, 'uid', FILTER_SANITIZE_STRING);

$images = glob(dirname(__FILE__)."/uploads/" . "*.{jpg,JPG,jpeg,JPEG,png,PNG}", GLOB_BRACE);
 foreach($images as $image){
   if(!str_contains($image, "_processed")){
    $processed_file_exists = file_exists(explode(".", $image)[0].".".explode(".", $image)[1].".".explode(".", $image)[2]."_processed".".".explode(".", $image)[3]);
    if(!$processed_file_exists){
        copy($image, explode(".", $image)[0].".".explode(".", $image)[1].".".explode(".", $image)[2]."_processed".".".explode(".", $image)[3]);
    }
   }
}

header('Location: index.php');