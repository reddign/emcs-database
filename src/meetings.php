<?PHP
$path = '';
require("includes/header.php");
require("../config.php");
require("functions/basic_html_functions.php");
require("functions/database_functions.php");
#require("functions/student_form_functions.php");
require("functions/meeting_form_functions.php");

?>
 <!-- Header -->
  <?php
    display_page_heading("Meetings","Log & Notes");
  ?>
  <?php
  $page = isset($_GET["page"])?$_GET["page"]:"search";
  switch($page){
    case "search":
      $string = isset($_GET["search"])?$_GET["search"]:"";
      #$students = get_student_by_name($string);
      display_search_meeting_form();
      display_meeting_list($meetings);
      break;
    /*case "add":
      display_student_form();
      break;
    case "edit":
      $sid = isset($_GET["sid"])?$_GET["sid"]:"";
      $student = get_student($sid);
      display_student_list($student);
      display_student_form($student);
      break;
    case "meeting":
      $sid = isset($_GET["sid"])?$_GET["sid"]:"";
      $student = get_student($sid);
      display_student_info($student);
      break;*/
  }
  
  require("includes/footer.php");
  ?>

