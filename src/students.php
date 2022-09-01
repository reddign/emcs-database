<?PHP
$path = '';
require("../config.php");
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
require("functions/student_form_functions.php");
$page = isset($_GET["page"])?$_GET["page"]:"search";
if(isset($_POST) && isset($_POST["page"]) && $_POST["page"]=="save"){
  process_student_form_data($_POST);
  exit;
}
require("includes/header.php");


  display_page_heading("Students","");

  display_student_page_navigation("Students");
 
 
  switch($page){
    case "search":
      $string = isset($_GET["search"])?$_GET["search"]:"";
      $students = get_student_by_name($string);
      display_search_form();
      display_student_list($students);
      break;
    case "add":
      display_student_form();
      break;
    case "edit":
      $sid = isset($_GET["sid"])?$_GET["sid"]:"";
      $student = get_student($sid);
      display_student_list($student);
      display_student_form($student);
      break;
    case "student":
      $sid = isset($_GET["sid"])?$_GET["sid"]:"";
      $student = get_student($sid);
      display_student_info($student);
      break;

  }
  

require("includes/footer.php");
