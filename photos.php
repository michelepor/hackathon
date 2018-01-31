<?php
//include auth.php file on all secure pages. it includes db.php
include("auth.php");
if(isset($_POST["submit"])) include("upload_img.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Hackathon - Photos</title>
  <!-- Latest compiled and minified Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css" />
  <script language='javascript' type='text/javascript'>
  //this function adds a preview of the picture to upload
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var preview = document.getElementById("pic_preview");
        preview.src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  </script>
</head>
<body style="text-align:left;">
  <div class="container">
    <h1>Photos</h1>
    <form name="registration" action="" method="post" enctype="multipart/form-data">
      <input name="imgToUpload" type="file" accept="image/*" onchange="readURL(this)"/>
      <input type="submit" name="submit" value="Upload picture" style="display:block;">
    </form>

    <div class="row display-flex">

      <?php
      $path = './uploads/';
      $files = glob($path. $_SESSION['id'] .'_*');
      foreach ($files as $file)
        echo   '<div class="col-md-4"><div class="box"><img src="'. $file.'"></div></div>';
      ?>

    </div>
    <br>
    <a style="float: right;" href="index.php">Back</a>
  </div>
</body>
</html>
