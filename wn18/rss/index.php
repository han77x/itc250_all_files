<?php
/**
 * index.php is the first page of our Survey Sez applications it's based on
 * demo_list_pager.php along with demo_view_pager.php provides a sample web application
 *
 * The difference between demo_list.php and demo_list_pager.php is the reference to the 
 * Pager class which processes a mysqli SQL statement and spans records across multiple  
 * pages. 
 *
 * The associated view page, demo_view_pager.php is virtually identical to demo_view.php. 
 * The only difference is the pager version links to the list pager version to create a 
 * separate application from the original list/view. 
 * 
 * @package SurveySez
 * @author William Fisher <william.fisher@seattlecenral.edu>
 * @version 0.01 2018/02/06
 * @link http://www.wfdesings.com/
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @see survey_view.php
 * @see Pager.php 
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
 
# SQL statement
//$sql = "select MuffinName, MuffinID, Price from test_Muffins";

/*$sql = 
"
select CONCAT(a.FirstName, ' ', a.LastName) AdminName, s.SurveyID, s.Title, s.Description, 
date_format(s.DateAdded, '%W %D %M %Y %H:%i') 'DateAdded' from "
. PREFIX . "surveys s, " . PREFIX . "Admin a where s.AdminID=a.AdminID order by s.DateAdded desc
";
*/

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'Feeds made with love & PHP in Seattle';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC250 Class Feeds are made with pure PHP! ' . $config->metaDescription;
$config->metaKeywords = 'RSS Feeds,PHP,Fun,Regular,Regular Expressions,'. $config->metaKeywords;

//adds font awesome icons for arrows on pager
$config->loadhead .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';

/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php

/*<!--
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
-->*/

    
echo '    
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
</div>';

//session_start();

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


get_footer();
?>
