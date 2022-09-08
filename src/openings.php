<?PHP
$path = '';
require("../config.php");
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
require("display_openings_navigation.php");
/*
if(isset($_GET["page"])){

  $page = $_GET["page"];
} else {
  $page = "search";
} */
//Sets the page value for display
$page = isset($_GET["page"])?$_GET["page"]:"search";
//If a form post lead the user here, we process the posted data in a function
if(isset($_POST) && isset($_POST["page"]) && $_POST["page"]=="save"){
  process_student_form_data($_POST);
  exit;
}
//otherwise we display the page
require("includes/header.php");

display_page_heading("Openings","");
display_openings_navigation("Openings");

require("includes/footer.php");
