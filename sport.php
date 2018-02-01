<?php
//include auth.php file on all secure pages. it includes db.php
include("auth.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Hackathon - Sport</title>
  <!-- Latest compiled and minified Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css" />
</head>
<body style="text-align:left;">
  <div class="container">
    <h1>Sport</h1>

    <form method="post" target="">
      <input type="text" name="team" placeholder="Input team name" value="<?php if (isset($_POST['team'])) echo $_POST['team'];?>" required>
    </form>

    <?php
    if (isset($_POST['team'])){
      // removes backslashes
      $team = stripslashes($_POST['team']);
      $csv = file_get_contents('http://www.football-data.co.uk/mmz4281/1718/I1.csv');
      $rows = explode("\n",$csv);
      $losers = array();
      echo "Your team won against:<br>";
      foreach($rows as $row) {
        //Div	Date	HomeTeam	AwayTeam	FTHG	FTAG	FTR
        @list(,,$home,$away,,,$result) = explode(',', $row);
        //Skip the match if here was a draw
        if ($result!="D") {
          // if the chosen team was the winning home team, echo loser away team
          if ((strcasecmp($team, $home) == 0) && ($result=="H")) $losers[] = $away;
          // if the chosen team was the winning away team, echo loser home team
          if ((strcasecmp($team, $away) == 0) && ($result=="A")) $losers[] = $home;
        }
      }
      $losers = array_unique($losers);
      sort($losers);
      foreach ($losers as $loser) echo $loser."<br>";

    }
    ?>

    <a style="float: right;" href="index.php">Back</a>
  </div>
</body>
</html>
