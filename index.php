<?php
//include auth.php file on all secure pages. it includes db.php
include("auth.php");

$news = simplexml_load_file('http://feeds.bbci.co.uk/news/rss.xml');
// Get first 5 words from title
//$news_title = implode(" ",array_slice(explode(" ", $news->channel->item[0]->title),0,5))."...";
// Get first 11 words from title
//$news_description = implode(" ",array_slice(explode(" ", $news->channel->item[0]->description),0,11))."...";
$news_description = $news->channel->item[0]->description;
$news_title = $news->channel->item[0]->title;

//<media:thumbnail width="976" height="549" url="http://c.files.bbci.co.uk/8117/production/_99774033_hi044358986.jpg"/>
//$news_image = $news->channel->item[0]->children( 'media', True )->content->attributes()['url'];
//<link>http://www.bbc.co.uk/news/world-asia-42843897</link> <guid isPermaLink="true">http://www.bbc.co.uk/news/world-asia-42843897</guid>

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Hackathon - Dashboard</title>
  <!-- Latest compiled and minified Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css" />

  <!-- Retrive location from browser and get weather from OpenWeatherMap -->
  <script type="text/javascript">
  function Get(yourUrl){
    var Httpreq = new XMLHttpRequest(); // a new request
    Httpreq.open("GET",yourUrl,false);
    Httpreq.send(null);
    return Httpreq.responseText;
  }

  function getLocation() {
    if (navigator.geolocation)
    navigator.geolocation.getCurrentPosition(showPosition);
    else
    x.innerHTML = "??";
  }

  function showPosition(position) {
    var city = document.getElementById("city");
    var degrees = document.getElementById("degrees");
    var icon = document.getElementById("weather_icon");

    var json_obj = JSON.parse(Get("http://api.openweathermap.org/data/2.5/weather?lat=" + position.coords.latitude + "&lon=" + position.coords.longitude + "&appid=d0a10211ea3d36b0a6423a104782130e&units=metric"));
    city.innerHTML = json_obj.name;
    degrees.innerHTML = parseInt(json_obj.main.temp) + " degrees";
    // icon.src = "img/"+json_obj.weather[0].main+"_icon.png";
    icon.src = "http://openweathermap.org/img/w/"+json_obj.weather[0].icon+".png";
  }

  window.onload = getLocation();
</script>
</head>
<body>
  <div class="container">
    <h1>Good day <?php echo $_SESSION['username']; ?></h1>
    <div class="row display-flex">
      <div class="col-md-4">
        <div class="box">
          <h3>Weather</h3>
          <div class="box_top row">
            <div class="col-md-6"><img id="weather_icon" src="#" alt="-"></div>
            <div id="degrees" class="col-md-6">-</div>
            <div id="city" class="col-md-12">-</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box">
          <h3>News</h3>
          <div class="box_top">
            <h4 id="news_title"><?php echo $news_title; ?></h4>
            <p id="news_text"><?php echo $news_description;?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <a href="sport.php">
          <div class="box">
            <h3>Sport</h3>
            <h4 id="sport_title" class="box_top">Football Results</h4>
            <p id="sport_text" class="box_top_top">Insert your favourite italian team's name and find out against which team they won!</p>
          </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="photos.php">
          <div class="box">
            <h3>Photos</h3>
            <img style="margin-top: 5px;" src="img/photos.png">
          </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="tasks.php">
          <div class="box">
            <h3>Tasks</h3>
            <img style="margin-top: 5px;" src="img/tasks.png">
          </div>
        </a>
      </div>
      <div class="col-md-4">
        <div class="box">
          <h3>Clothes</h3>
          <div id="piechart" class="box_top" style="display: inline-block; margin: 5px auto 0;">Loading...</div>
        </div>
      </div>
    </div><br>
    <a href="logout.php">Logout</a>
  </div>
  <!-- Pie graph - Source: https://developers.google.com/chart/interactive/docs/gallery/piechart -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
  // Load google charts
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  var warmers = JSON.parse(Get("https://cors.io/?https://therapy-box.co.uk/hackathon/clothing-api.php?username=swapnil")).payload;
  var wardrobe = [['Warmer','Total']];
  var found;
  for (var i=0; i < warmers.length; i++) {
    found = 0;
    for (var j=0; j < wardrobe.length; j++) {
      if (wardrobe[j][0] === warmers[i].clothe) {
        wardrobe[j][1]++;
        found = 1;
      }
    }
    if (found===0) { wardrobe.push([warmers[i].clothe,0]); }
  }

  // Draw the chart and set the chart values
  function drawChart() {
    var data = google.visualization.arrayToDataTable(wardrobe);

    // Optional; add a title and set the width and height of the chart
    var options = {'backgroundColor':'none', 'chartArea':{'width':'90%','height':'90%'}, 'width':318, 'height':180, 'legend':'none'};

    // Display the chart inside the <div> element with id="piechart"
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
  }
  </script>
</body>
</html>
