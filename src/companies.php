<?PHP
$path = '';
require("../config.php");
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
require("functions/companies_form_function.php");
$page = isset($_GET["page"])?$_GET["page"]:"search";
if(isset($_POST) && isset($_POST["page"]) && $_POST["page"]=="save"){
  process_student_form_data($_POST);
  exit;
}
require("includes/header.php");


  display_page_heading("Companies","");

  display_company_page_navigation("Students");
 
 
  switch($page){
    case "search":
      $string = isset($_GET["search"])?$_GET["search"]:"";
      $students = get_company_by_name($string);
      display_search_form();
      display_company_list($students);
      break;
    case "add":
      display_company_form();
      break;
    case "edit":
      $sid = isset($_GET["sid"])?$_GET["sid"]:"";
      $student = get_company($sid);
      display_company_list($student);
      display_company_form($student);
      break;
    case "student":
      $sid = isset($_GET["sid"])?$_GET["sid"]:"";
      $student = get_company($sid);
      display_company_info($student);
      break;

  }
  

require("includes/footer.php");
