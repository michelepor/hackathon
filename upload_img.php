<?php
//include auth.php file on all secure pages. it includes db.php
include("auth.php");

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["imgToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["imgToUpload"]["tmp_name"]);
  if($check !== false) {
    // echo "File is an image - " . $check["mime"] . ".";
    // $uploadOk = 1;
  } else {
    echo "<h3 class='error'>File is not an image.</h3>";
    $uploadOk = 0;
  }

  // Check if file already exists
  $file_n = 0;
  while (file_exists($target_dir . $_SESSION['id'] . "_" . $file_n . "." . $imageFileType))
  $file_n++;
  $target_file = $target_dir . $_SESSION['id'] . "_" . $file_n . "." . $imageFileType;
  // Check file size
  if ($_FILES["imgToUpload"]["size"] > 500000) {
    echo "<h3 class='error'>Sorry, your file is too large.</h3>";
    $uploadOk = 0;
  }
  // Allow certain file ats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "<h3 class='error'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</h3>";
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "<h3 class='error'>Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["imgToUpload"]["tmp_name"], $target_file)) {
      echo "<h3>The image ". basename( $_FILES["imgToUpload"]["name"]). " has been uploaded.</h3>";
    } else {
      echo "<h3 class='error'>Sorry, there was an error uploading your file.</h3>";
    }
  }

}
?>
