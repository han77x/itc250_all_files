<?php
/**
 * survey_view.php along with index.php provides a List/View application for the 
 * SurveySez project
 * @package SurveySez
 * @author Hanbo Yoon
 * @version 0.1 2018/02/08
 * @link none
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @see survey_list.php
 * @todo none
 */
 
require '../inc_0700/config.php'; #provides configuration, pathing, error handling, db credentials
spl_autoload_register('MyAutoLoader::NamespaceLoader');//required to load SurveySez namespace objects
$config->metaRobots = 'no index, no follow';#never index survey pages

# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "surveys/index.php");
}

$mySurvey = new SurveySez\Survey($myID); //MY_Survey extends survey class so methods can be added
if($mySurvey->isValid)
{
	$config->titleTag = "'" . $mySurvey->Title . "' Survey!";
}else{
	$config->titleTag = smartTitle(); //use constant 
}
#END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h3><?=$mySurvey->Title;?></h3>

<?php

if($mySurvey->isValid)
{ #check to see if we have a valid SurveyID
	echo '<p>' . $mySurvey->Description . '</p>';
	echo $mySurvey->showQuestions();
}else{
	echo "Sorry, no such survey!";	
}

get_footer(); #defaults to theme footer or footer_inc.php


