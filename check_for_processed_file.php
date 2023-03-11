<?php
header("Content-Type: application/json");
$uid = $_GET["uid"];


$original_file_exists = !empty(glob(dirname(__FILE__)."/uploads/".$uid.".*"));
$processed_file_exists = !empty(glob(dirname(__FILE__)."/uploads/".$uid."_processed.*"));

if($original_file_exists){
    if($processed_file_exists){
        $data["status"] = "processed";
    }else{
        $data["status"] = "waiting";
    }
}else{
    $data["status"] = "noupload";
}


$data["original_filename"] = str_replace(dirname(__FILE__)."/", "", glob(dirname(__FILE__)."/uploads/".$uid. "*.{jpg,JPG,jpeg,JPEG,png,PNG}", GLOB_BRACE)[0]);
$data["processed_filename"] = str_replace(dirname(__FILE__)."/", "", glob(dirname(__FILE__)."/uploads/".$uid. "*_processed.{jpg,JPG,jpeg,JPEG,png,PNG}", GLOB_BRACE));

$data["uid"] = $uid;
echo json_encode($data);
exit();