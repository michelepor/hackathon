<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Hackathon - Registration</title>
  <!-- Latest compiled and minified Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css" />
  <!-- Script for password confirmation -->
  <script language='javascript' type='text/javascript'>
    function check(input) {
      if (input.value != document.getElementById('password').value) {
        input.setCustomValidity('Password must be matching.');
      } else {
        input.setCustomValidity('');
      }
    }

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
<body>
  <div class="container">
    <h1>Hackathon</h1>

    <?php
    require('db.php');
    // If form submitted, insert values into the database.
    if (isset($_REQUEST['username'])){
      // removes backslashes
      $username = stripslashes($_REQUEST['username']);
      //escapes special characters in a string
      $username = mysqli_real_escape_string($con,$username);
      $email = stripslashes($_REQUEST['email']);
      $email = mysqli_real_escape_string($con,$email);
      // retrieve and hash the password
      $password = stripslashes($_REQUEST['password']);
      $password = password_hash($password,PASSWORD_BCRYPT,$options);
      $password = mysqli_real_escape_string($con,$password);
      $reg_date = date("Y-m-d H:i:s");

      //Checking is user existing in the database or not
      $query = "SELECT id, username FROM `users` WHERE username='$username' or email='$email'";
      $result = mysqli_query($con,$query) or die(mysql_error());
      $rows = mysqli_num_rows($result);
      if ($rows==1) {
        echo '<h3 class="error">Username or email address already in use.</h3><a href="javascript:history.back(-1);">Click here to try again</a></div></body></html>';
      }else {

        $query = "INSERT into `users` (username, password, email, reg_date) VALUES ('$username', '".$password."', '$email', '$reg_date')";
        $result = mysqli_query($con,$query);
        if($result){
          $query = "SELECT id, username FROM `users` WHERE email='$email'";
          $result = mysqli_query($con,$query) or die(mysql_error());
          $row = mysqli_fetch_assoc($result);
          $_SESSION['id'] = $row['id'];
          $_SESSION['username'] = $row['username'];

          //if the user selected a picture, loads the script
          if (isset($_REQUEST['imgToUpload'])) include('upload_img.php');

          echo "<h3>You are registered successfully.</h3><a href='login.php'>Click here to Login</a></div></body></html>";
        }
      }
    }else{
      ?>

      <form name="registration" action="" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6">
            <input type="text" name="username" placeholder="Username" value="<?php $username; ?>" required />
          </div>
          <div class="col-md-6">
            <input type="email" name="email" placeholder="Email" value="<?php $email; ?>" required />
          </div>
          <div class="col-md-6">
            <input type="password" id="password" name="password" placeholder="Password" required />
          </div>
          <div class="col-md-6">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" oninput="check(this)" required />
          </div>
          <div class="col-md-6 col-md-offset-3">
            <div class="box box_dark" style="width: 60%;">
              <div class="image-upload centered">
                <label for="file-input">
                  <img class="centered" id="pic_preview" src="#" alt="Add picture" />
                </label>
                <input id="file-input" name="imgToUpload" type="file" accept="image/*" onchange="readURL(this)"/>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <input class="hk_btn" name="submit" type="image" src="img/Register_button.png" alt="Register" value="Register" />
          </div>

        </div>
      </form>
    </div>
  <?php } ?>
</body>
</html>
