<?php 
session_start(); 
$uid = session_id();

$command = filter_input(INPUT_GET, 'command', FILTER_SANITIZE_STRING);

if($command !== NULL){
  if($command = "destroysession"){
    $_SESSION = array();
    session_destroy();
    session_unset();
    session_write_close();

    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
    }

    header('Location: index.php'); 
  }
}

?>
<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>AI Demo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/bootstrap.min.css">
<link rel="stylesheet" href="assets/styles.css">

</head>

<body>

<div class="row mt-5">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="hidden" id="uid" name="uid" value="<?php echo($uid) ?>">
            <input type="file" name="fileToUpload" id="fileToUpload" class="btn btn-secondary">
            <input id="submitBtn" type="submit" value="Upload Image" name="submit" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
    <div class="row mt-5 mb-5">
      <div class="col-md-12">
        <p id="status"></p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div id="original_container" class="image_container">
          Original
          <img src="" alt="">
        </div>
      </div>
      <div class="col-md-6">
        <div id="processed_container" class="image_container">
          Processed
          <img src="" alt="">
        </div>
      </div>
    </div>
    
    <div class="row mt-5 mb-5">
      <div class="col-md-12">
        <hr>
        Admin stuff </br>
        <a href="index.php?command=destroysession">Start over again</a> </br>
        <span class="simulateSpan"><a href="simulate_processing.php?uid=<?php echo($uid) ?>">Simulate processing</a></span>
      </div>
    </div>
  </div>
  <div class="col-md-3"></div>
</div>



</body>


<script src="assets/jquery.min.js"></script>
<script src="assets/script.js"></script>
</html>
