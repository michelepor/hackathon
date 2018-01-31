<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Hackathon - Login</title>
  <!-- Latest compiled and minified Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <h1>Hackathon</h1>
    <?php
    require('db.php');
    session_start();
    // If form submitted, insert values into the database.
    if (isset($_POST['username'])){
      // removes backslashes
      $username = stripslashes($_REQUEST['username']);
      //escapes special characters in a string
      $username = mysqli_real_escape_string($con,$username);
      $password = stripslashes($_REQUEST['password']);
      $password = mysqli_real_escape_string($con,$password);
      //Checking is user existing in the database or not
      $query = "SELECT id, username FROM `users` WHERE username='$username';";
      $result = mysqli_query($con,$query) or die(mysql_error());
      $rows = mysqli_num_rows($result);

      if($rows==1)
      if(password_verify($password, $row["password"])) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        // Redirect user to index.php
        header("Location: index.php");
      } else
      echo "<h3 class='error'>Incorrect username/password.</h3>";
    }
    ?>

    <form action="" method="post" name="login">
      <div class="row">
        <div class="col-md-6">
          <input type="text" name="username" placeholder="Username" required />
        </div>
        <div class="col-md-6">
          <input type="password" name="password" placeholder="Password" required />
        </div>
        <div class="col-md-12">
          <input class="hk_btn" name="submit" type="image" src="img/Login_button.png" alt="Login" value="Login" />
        </div>
      </form>
      <p>New to the hackathon? <a href='signup.php'>Sign up</a></p>
    </div>
  </body>
  </html>
