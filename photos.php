<?php
//include auth.php file on all secure pages. it includes db.php
include("auth.php");
//if the user selected a picture, loads the script
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

    <div class="row display-flex">

      <div class="col-md-4"><div class="box"><div class="image-upload centered">
        <form action="" class="image-upload" method="post" enctype="multipart/form-data">
          <label for="file-input">
            <img class="centered" id="pic_preview" src="#" alt="Add picture" />
          </label>
          <input id="file-input" name="imgToUpload" type="file" accept="image/*" onchange="readURL(this)"/>
          <input type="submit" name="submit" value="Upload" class="bottom-corner"></form>
        </div></div></div>

        <?php
        $path = './uploads/';
        $files = glob($path. $_SESSION['id'] .'_*');


        if (isset($_GET['p'])) $offset = $_GET['p'];
        else $offset = 1; //page

        if (isset($_GET['q'])) $quantity = $_GET['q'];
        else $quantity = 10; //number of items to display

        if (count($files)>0) {
          $pages = ((int) (count($files)/$quantity)) +1;

          //get subset of file array
          //       array_slice(array,  start,     length,   preserve)
          $files = array_slice($files, ($offset-1)*$quantity, $quantity);
        } else $pages = 1;

        foreach ($files as $file)
        echo   '<div class="col-md-4"><div class="box"><img src="'. $file.'"></div></div>';

        for ($i = 1; $i <= $pages; $i++) {
          if ($i==$offset) echo " <u>";
          echo "<a href='?q=".$quantity."&p=".$i."'>".$i."</a> ";
          if ($i==$offset) echo "</u>"; else echo " ";
        }

        ?>

      </div>
      <br>
      <a style="float: right;" href="index.php">Back</a>
    </div>
  </body>
  </html>
