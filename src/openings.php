<?PHP
$path = '';
require("../config.php");
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
require("functions/openings_functions.php");
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

display_page_heading("Job Openings","");
display_openings_navigation("Openings");

switch($page){
  case "search":
    $string = isset($_GET["search"])?$_GET["search"]:"";
    $openings = get_job_by_name($string);
    display_search_form();
    display_job_list($openings);
    break;
  /*
  case "add":
    display_student_form();
    break;
  case "edit":
    $sid = isset($_GET["sid"])?$_GET["sid"]:"";
    $student = get_student($sid);
    display_student_form($student);
    break;
    
  case "student":
    $sid = isset($_GET["sid"])?$_GET["sid"]:"";
    $student = get_student($sid);
    display_student_info($student);
    break;
  */

}

require("includes/footer.php");
