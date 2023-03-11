
<?php

$uid = filter_input(INPUT_POST, 'uid', FILTER_SANITIZE_STRING);

$target_dir = "uploads/";
$target_file = $target_dir . $uid.".".strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
$data["debug"] = $target_file;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $data["image"] = "valid";
    $data["status"] = "ok";
    $uploadOk = 1;
  } else {
    $data["image"] = "invalid";
    $data["status"] = "error";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  $data["status"] = "error";
  $data["image"] = "already exists";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  $data["image"] = "too large";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  $data["image"] = "invalid filetype";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  $data["status"] = "error";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $data["status"] = "ok";
    $data["image"] = "successfully uploaded";
  } else {
    $data["status"] = "error";
    $data["image"] = "unspecified error";
  }
}


header("Content-Type: application/json");
echo json_encode($data);
exit();

?>
