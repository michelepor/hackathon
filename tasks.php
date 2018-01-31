<?php
//include auth.php file on all secure pages. it includes db.php
include("auth.php");

//add new task to the database
if (isset($_POST['new_task'])){
  // removes backslashes
  $new_task = stripslashes($_POST['new_task']);
  //escapes special characters in a string
  $new_task = mysqli_real_escape_string($con,$new_task);
  $query = "INSERT INTO tasks (task, user, status) VALUES ('" . $new_task . "','" . $_SESSION['id'] . "',0);";
  mysqli_query($con,$query) or die(mysql_error());
}

//switch status to an existing task in the database
if (isset($_POST['id'])){
  $query = "UPDATE tasks SET status = NOT status WHERE id = '" . $_POST['id'] . "' AND user = '" . $_SESSION['id'] . "';";
  mysqli_query($con,$query) or die(mysql_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Hackathon - Tasks</title>
  <!-- Latest compiled and minified Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css" />
</head>
<body style="text-align:left;">
  <div class="container">
    <h1>Tasks</h1>
    <table class="table tasks">

      <?php
      //show all the task for the current user
      $query = "SELECT * FROM tasks WHERE user='" . $_SESSION['id'] . "' ORDER BY status DESC, id ASC;";
      $result = mysqli_query($con,$query) or die(mysql_error());
      $numrows = mysqli_num_rows($result);
      if($numrows>0) while( $row = mysqli_fetch_assoc($result) ){
        echo "<tr><td>".$row['task']."</td>";
        echo "<td><form method='post' action=''><input type='hidden' name='id' value='" . $row['id'] . "'><input class='ck_btn' type='submit' value='";
        if ($row['status']!=="0") echo "v";
        else echo " ";
        echo "'></form></td></tr>";
      } else echo "<tr><td>There are no tasks at the moment.</td></tr>";
      ?>

    </table>
    <br>
    <form method="post" target="">
      <input name="submit" type="image" src="img/Plus_button_small.png" alt="+" value="Add task" />
      <input type="text" name="new_task" required>
    </form>
    <a style="float: right;" href="index.php">Back</a>
  </div>
</body>
</html>
