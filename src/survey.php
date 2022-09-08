<?PHP
$path = '';
require("includes/header.php");
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
require("functions/survey_functions.php");
?>

 <!-- Header -->
 <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>Survey</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Student Interest.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>

<?php
$page = isset($_GET["page"])?$_GET["page"]:"add";
display_survey_page_navigation("Survey");

switch($page){
    case "add":
      display_survey_form();
      break;
    case "search":
      echo "You do not have access to this page!"
      //TODO: add view page for admins
      break;
  }
  
  



require("includes/footer.php");
