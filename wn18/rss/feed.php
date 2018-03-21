<html>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>

.card-text, .card, .card-header{
  padding: 5px;
}

.card-header{
  background-color: lightblue;
}

img{
  padding: 10px !important;
}
</style>


<div class="btn-group dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Pets
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="feed.php?ID=0">Cats</a></li>
    <li><a href="feed.php?ID=1">Dogs</a></li>
    <li><a href="feed.php?ID=2">Pot-bellied Pigs</a></li>
  </ul>
</div>

<div class="btn-group dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Art
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="feed.php?ID=3">Music</a></li>
    <li><a href="feed.php?ID=4">Painting</a></li>
    <li><a href="feed.php?ID=5">Dance</a></li>
  </ul>
</div>

<div class="btn-group dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Video Games
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="feed.php?ID=6">XBox One</a></li>
    <li><a href="feed.php?ID=7">Playstation 4</a></li>
    <li><a href="feed.php?ID=8">PC</a></li>
  </ul>
</div>

</html>


<?php
session_start();

$database = array("https://news.google.com/news/rss/search/section/q/cats%20-baseball/cats%20-baseball?hl=en&gl=US&ned=us", // Array that hold all the RSS, replace with DB later
"https://news.google.com/news/rss/search/section/q/dogs%20-%22hot%20dogs%22/dogs%20-%22hot%20dogs%22?hl=en&gl=US&ned=us",
"https://news.google.com/news/rss/search/section/q/pot%20bellied%20pig/pot%20bellied%20pig?hl=en&gl=US&ned=us",
"https://news.google.com/news/rss/search/section/q/music/music?hl=en&gl=US&ned=us",
"https://news.google.com/news/rss/search/section/q/painting/Painting?hl=en&gl=US&ned=us",
"https://news.google.com/news/rss/search/section/q/dancing/Dancing?hl=en&gl=US&ned=us",
"https://news.google.com/news/rss/search/section/q/Xbox%20one/Xbox%20one?hl=en&gl=US&ned=us",
"https://news.google.com/news/rss/search/section/q/Playstation%204/Playstation%204?hl=en&gl=US&ned=us",
"https://news.google.com/news/rss/search/section/q/PC%20gaming/PC%20gaming?hl=en&gl=US&ned=us");

function displayNews($num, $array)
{ // Function displays the news in a neat manner when given a ID
  $request = $array[$num]; // choose RSS
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  echo "The ID stored in the session is " . $_SESSION['id']; // I left this hear so you know what the session is, we can delete it later

  echo '<h1>' . $xml->channel->title . '</h1>'; // ouputs the HTML
  foreach($xml->channel->item as $story){
    echo'<div class="card">
    <h3 class="card-header">'. $story->title . '</h3>
    <div class"card-block> <p class ="card-text">'. $story->description.'</p> </div>
  </div>
  <hr>';
  }// end of foreach
}//end of displayNews




if(isset($_GET["ID"])){ //if there is id in the URL it will choose that to display
  $ID = $_GET["ID"];
  $_SESSION["id"] =  $ID;
  displayNews($ID, $database);
}
elseif(isset($_SESSION["id"])){ // if there is no id in the URL it will pull from the session
  displayNews($_SESSION["id"], $database);
}
else{
  echo" Choose a subject to explore!"; //if there is niether, it will tell you to pickQ
}

?>
